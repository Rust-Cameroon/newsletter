use axum::{
    extract::{Path, Multipart, State, Request},
    http::{StatusCode, HeaderMap},
    response::IntoResponse,
    routing::{get, delete, put, post},
    Json, Router, middleware,
};
use serde::{Deserialize, Serialize};
use std::collections::HashMap;
use std::fs;
use std::path::Path as StdPath;
use tower::ServiceBuilder;
use tower_http::{
    cors::{Any, CorsLayer},
    services::ServeDir,
    trace::TraceLayer,
};
// use tower_governor::{governor::GovernorConfigBuilder, GovernorLayer};
use tracing::{info, error, instrument, warn};
use tracing_subscriber;
use aws_sdk_s3::Client as S3Client;
use bytes::Bytes;
use envconfig::Envconfig;
use jsonwebtoken::{encode, decode, Header, Algorithm, Validation, EncodingKey, DecodingKey};
use chrono::{Utc, Duration};
use sha2::{Sha256, Digest};
use base64::Engine;

#[derive(Envconfig, Clone, Debug)]
pub struct Config {
    #[envconfig(from = "PORT", default = "8000")]
    pub port: u16,

    #[envconfig(from = "RUST_LOG", default = "info")]
    pub rust_log: String,

    #[envconfig(from = "DATABASE_URL", default = "postgres://user:password@localhost:5432/rustcameroon")]
    pub database_url: String,

    #[envconfig(from = "MINIO_ENDPOINT", default = "http://localhost:9000")]
    pub minio_endpoint: String,

    #[envconfig(from = "MINIO_ACCESS_KEY", default = "minioadmin")]
    pub minio_access_key: String,

    #[envconfig(from = "MINIO_SECRET_KEY", default = "minioadmin123")]
    pub minio_secret_key: String,

    #[envconfig(from = "MINIO_BUCKET", default = "rust-cameroon-images")]
    pub minio_bucket: String,

    #[envconfig(from = "JWT_SECRET", default = "RustCameroon-JWT-Secret-2024-Change-In-Production")]
    pub jwt_secret: String,

    #[envconfig(from = "ADMIN_PASSWORD", default = "RustCameroon2024!")]
    pub admin_password: String,

    #[envconfig(from = "ADMIN_IP_WHITELIST", default = "")]
    pub admin_ip_whitelist: String,
}

// JWT Claims
#[derive(Debug, Serialize, Deserialize)]
struct Claims {
    sub: String,
    exp: usize,
    iat: usize,
    admin: bool,
}

// Login request
#[derive(Debug, Deserialize)]
struct LoginRequest {
    password: String,
}

// Login response
#[derive(Debug, Serialize)]
struct LoginResponse {
    token: String,
    expires_in: u64,
}

// Admin session tracking
#[derive(Debug, Clone)]
struct AdminSession {
    user_id: String,
    created_at: chrono::DateTime<Utc>,
    last_activity: chrono::DateTime<Utc>,
    ip_address: String,
}

#[derive(Debug, Serialize, Deserialize, Clone)]
pub struct Post {
    pub id: String,
    pub title: String,
    pub content: String,
    pub excerpt: String,
    pub author: String,
    pub date: String,
    pub tags: Vec<String>,
    pub image_url: Option<String>, // Keep for backward compatibility, will be populated from MinIO
    pub slug: String,
}

#[derive(Debug, Deserialize)]
pub struct NewPost {
    pub title: String,
    pub content: String,
    pub excerpt: String,
    pub author: String,
    pub tags: Vec<String>,
    pub image_url: Option<String>,
}

#[derive(Debug, Deserialize)]
pub struct UpdatePost {
    pub title: Option<String>,
    pub content: Option<String>,
    pub excerpt: Option<String>,
    pub author: Option<String>,
    pub tags: Option<Vec<String>>,
    pub image_url: Option<String>,
}

#[derive(Debug, Serialize, Deserialize, Clone)]
pub struct Event {
    pub id: String,
    pub title: String,
    pub description: String,
    pub date: String,
    pub time: String,
    pub location: String,
    pub event_type: String,
    pub status: String, // "upcoming" or "past"
    pub registration_url: Option<String>, // Optional registration link
    pub created_at: String,
}

#[derive(Debug, Deserialize)]
pub struct NewEvent {
    pub title: String,
    pub description: String,
    pub date: String,
    pub time: String,
    pub location: String,
    pub event_type: String,
    pub registration_url: Option<String>,
}

#[derive(Debug, Deserialize)]
pub struct UpdateEvent {
    pub title: Option<String>,
    pub description: Option<String>,
    pub date: Option<String>,
    pub time: Option<String>,
    pub location: Option<String>,
    pub event_type: Option<String>,
    pub registration_url: Option<String>,
}

// In-memory storage for posts (in production, use a database)
type PostsStorage = std::sync::Arc<std::sync::Mutex<HashMap<String, Post>>>;
type EventsStorage = std::sync::Arc<std::sync::Mutex<HashMap<String, Event>>>;
type SessionsStorage = std::sync::Arc<std::sync::Mutex<HashMap<String, AdminSession>>>;

// Combined application state
#[derive(Clone, Debug)]
struct AppState {
    posts: PostsStorage,
    events: EventsStorage,
    sessions: SessionsStorage,
    minio: MinioService,
    config: Config,
}

// MinIO client wrapper using AWS SDK configured for MinIO
#[derive(Clone, Debug)]
struct MinioService {
    client: S3Client,
    bucket_name: String,
}

impl MinioService {
    async fn new(config: &Config) -> Result<Self, Box<dyn std::error::Error + Send + Sync>> {
        info!("Initializing MinIO service with endpoint: {}", config.minio_endpoint);
        info!("MinIO access key: {}", config.minio_access_key);
        info!("MinIO bucket: {}", config.minio_bucket);

        // Retry logic for MinIO connection
        let mut retries = 0;
        let max_retries = 10;
        let retry_delay = std::time::Duration::from_secs(2);

        loop {
            match Self::try_connect(
                &config.minio_endpoint,
                &config.minio_access_key,
                &config.minio_secret_key,
                &config.minio_bucket,
            ).await {
                Ok(service) => {
                    info!("MinIO service initialized successfully");
                    return Ok(service);
                }
                Err(e) => {
                    retries += 1;
                    if retries >= max_retries {
                        error!("Failed to initialize MinIO service after {} retries: {}", max_retries, e);
                        return Err(e);
                    }
                    error!("MinIO connection attempt {} failed: {}. Retrying in {:?}...", retries, e, retry_delay);
                    tokio::time::sleep(retry_delay).await;
                }
            }
        }
    }

    async fn try_connect(
        endpoint: &str,
        access_key: &str,
        secret_key: &str,
        bucket_name: &str,
    ) -> Result<Self, Box<dyn std::error::Error + Send + Sync>> {
        // Configure AWS SDK specifically for MinIO (version 0.31)
        let credentials = aws_sdk_s3::config::Credentials::new(
            access_key,
            secret_key,
            None,
            None,
            "static",
        );

        let region = aws_sdk_s3::config::Region::new("us-east-1");
        
        let s3_config = aws_sdk_s3::config::Builder::new()
            .region(region)
            .endpoint_url(endpoint)
            .credentials_provider(credentials)
            .force_path_style(true) // MinIO typically requires path-style URLs
            .build();

        let client = S3Client::from_conf(s3_config);

        let service = MinioService { 
            client, 
            bucket_name: bucket_name.to_string(),
        };
        
        // Ensure bucket exists
        service.ensure_bucket_exists().await?;
        
        Ok(service)
    }

    async fn ensure_bucket_exists(&self) -> Result<(), Box<dyn std::error::Error + Send + Sync>> {
        match self.client.head_bucket().bucket(&self.bucket_name).send().await {
            Ok(_) => {
                info!("MinIO bucket exists: {}", self.bucket_name);
            }
            Err(e) => {
                // Log the specific error for debugging
                error!("Head bucket failed: {:?}", e);
                
                // Bucket doesn't exist, create it
                info!("MinIO bucket doesn't exist: {}. Creating it...", self.bucket_name);
                
                match self.client
                    .create_bucket()
                    .bucket(&self.bucket_name)
                    .send()
                    .await {
                    Ok(_) => {
                        info!("Successfully created MinIO bucket: {}", self.bucket_name);
                    }
                    Err(create_err) => {
                        error!("Failed to create bucket: {:?}", create_err);
                        return Err(create_err.into());
                    }
                }
            }
        }

        // Set bucket policy for public read access
        self.set_bucket_policy().await?;

        Ok(())
    }

    async fn set_bucket_policy(&self) -> Result<(), Box<dyn std::error::Error + Send + Sync>> {
        let policy = format!(
            r#"{{
                "Version": "2012-10-17",
                "Statement": [
                    {{
                        "Effect": "Allow",
                        "Principal": "*",
                        "Action": "s3:GetObject",
                        "Resource": "arn:aws:s3:::{}/*"
                    }}
                ]
            }}"#,
            self.bucket_name
        );

        match self.client
            .put_bucket_policy()
            .bucket(&self.bucket_name)
            .policy(policy)
            .send()
            .await {
            Ok(_) => {
                info!("Successfully set public read policy for bucket: {}", self.bucket_name);
            }
            Err(e) => {
                error!("Failed to set bucket policy: {:?}", e);
                // Don't fail the entire operation if policy setting fails
                // The bucket will still work, just might not be publicly accessible
            }
        }

        Ok(())
    }

    async fn upload_file(&self, filename: &str, data: Bytes) -> Result<String, Box<dyn std::error::Error + Send + Sync>> {
        let object_name = format!("{}/{}", chrono::Utc::now().format("%Y/%m/%d"), filename);
        
        info!("Uploading file: {} to bucket: {} with key: {}", filename, self.bucket_name, object_name);
        
        self.client
            .put_object()
            .bucket(&self.bucket_name)
            .key(&object_name)
            .body(data.into())
            .send()
            .await?;

        // Return URL that will be served through nginx proxy
        let url = format!("https://rustcameroon.com/minio/{}/{}", self.bucket_name, object_name);
        
        info!("File uploaded successfully. URL: {}", url);

        Ok(url)
    }
}

#[instrument]
async fn get_posts(State(state): State<AppState>) -> impl IntoResponse {
    let posts = match state.posts.lock() {
        Ok(posts) => posts,
        Err(e) => {
            error!("Failed to acquire posts lock: {}", e);
            return (StatusCode::INTERNAL_SERVER_ERROR, "Database lock error").into_response();
        }
    };
    let posts_vec = get_posts_with_local_images(&posts);
    info!("Fetched all posts with local images for first 5");
    Json(posts_vec).into_response()
}

#[instrument]
async fn get_post(
    Path(slug): Path<String>,
    State(state): State<AppState>,
) -> impl IntoResponse {
    let posts = match state.posts.lock() {
        Ok(posts) => posts,
        Err(e) => {
            error!("Failed to acquire posts lock: {}", e);
            return (StatusCode::INTERNAL_SERVER_ERROR, "Database lock error").into_response();
        }
    };
    match posts.get(&slug) {
        Some(post) => {
            info!("Fetched post with slug: {}", slug);
            Json(post.clone()).into_response()
        }
        None => {
            error!("Post not found with slug: {}", slug);
            (StatusCode::NOT_FOUND, "Post not found").into_response()
        }
    }
}

#[instrument]
async fn create_post(
    State(state): State<AppState>,
    mut multipart: Multipart,
) -> impl IntoResponse {
    let mut post_data = std::collections::HashMap::new();
    let mut image_url = None;
    let mut image_data = None;
    
    // Parse multipart form data
    loop {
        let field_result = multipart.next_field().await;
        let field = match field_result {
            Ok(Some(field)) => field,
            Ok(None) => break, // No more fields
            Err(e) => {
                error!("Failed to parse multipart field: {}", e);
                return (StatusCode::BAD_REQUEST, format!("Failed to parse form data: {}", e)).into_response();
            }
        };
        
        if let Some(name) = field.name() {
            match name {
                "file" => {
                    // Handle file upload
                    if let Some(filename) = field.file_name() {
                        let filename = filename.to_string();
                        let data = match field.bytes().await {
                            Ok(data) => data,
                            Err(e) => {
                                error!("Failed to read file data: {}", e);
                                return (StatusCode::INTERNAL_SERVER_ERROR, format!("Failed to read file data: {}", e)).into_response();
                            }
                        };
                        // Upload to MinIO first
                        match state.minio.upload_file(&filename, data.clone()).await {
                            Ok(url) => {
                                let url_clone = url.clone();
                                image_url = Some(url);
                                info!("Uploaded image to MinIO: {} -> {}", filename, url_clone);
                                
                                // Store image data for potential local saving
                                image_data = Some(data);
                            }
                            Err(e) => {
                                error!("Failed to upload image to MinIO: {}", e);
                                return (StatusCode::INTERNAL_SERVER_ERROR, format!("Failed to upload image: {}", e)).into_response();
                            }
                        }
                    }
                }
                _ => {
                    // Handle other form fields
                    let name = name.to_string();
                    if let Ok(value) = field.text().await {
                        post_data.insert(name, value);
                    }
                }
            }
        }
    }
    
    // Extract required fields
    let title = match post_data.get("title") {
        Some(title) => title,
        None => return (StatusCode::BAD_REQUEST, "Missing title field").into_response(),
    };
    let content = match post_data.get("content") {
        Some(content) => content,
        None => return (StatusCode::BAD_REQUEST, "Missing content field").into_response(),
    };
    let excerpt = match post_data.get("excerpt") {
        Some(excerpt) => excerpt,
        None => return (StatusCode::BAD_REQUEST, "Missing excerpt field").into_response(),
    };
    let author = match post_data.get("author") {
        Some(author) => author,
        None => return (StatusCode::BAD_REQUEST, "Missing author field").into_response(),
    };
    let tags_str = post_data.get("tags").cloned().unwrap_or_default();
    let tags: Vec<String> = tags_str.split(',')
        .map(|s| s.trim().to_string())
        .filter(|s| !s.is_empty())
        .collect();
    
    let slug = title.to_lowercase().replace(' ', "-");
    let post = Post {
        id: uuid::Uuid::new_v4().to_string(),
        slug: slug.clone(),
        date: chrono::Utc::now().format("%Y-%m-%d").to_string(),
        title: title.clone(),
        content: content.clone(),
        excerpt: excerpt.clone(),
        author: author.clone(),
        tags,
        image_url,
    };

    // First, check if this post will be in the first 5 and save image locally if needed
    let should_save_locally = {
        let posts = match state.posts.lock() {
            Ok(posts) => posts,
            Err(e) => {
                error!("Failed to acquire posts lock: {}", e);
                return (StatusCode::INTERNAL_SERVER_ERROR, "Failed to save post: database lock error").into_response();
            }
        };
        is_in_first_five_posts(&posts, &post.id)
    };
    
    // Save image locally if needed (before acquiring the mutex again)
    if let Some(data) = image_data {
        if should_save_locally {
            let filename = format!("{}.jpg", post.id);
            match save_image_locally(&data, &filename).await {
                Ok(local_url) => {
                    info!("Saved image locally for first 5 post: {} -> {}", post.id, local_url);
                }
                Err(e) => {
                    warn!("Failed to save image locally for post {}: {}", post.id, e);
                }
            }
        }
    }
    
    // Now acquire the mutex again to save the post
    let mut posts = match state.posts.lock() {
        Ok(posts) => posts,
        Err(e) => {
            error!("Failed to acquire posts lock: {}", e);
            return (StatusCode::INTERNAL_SERVER_ERROR, "Failed to save post: database lock error").into_response();
        }
    };
    posts.insert(slug.clone(), post.clone());
    
    // Save to JSON file
    if let Err(e) = save_posts_to_file(&posts) {
        error!("Failed to save posts: {}", e);
        return (StatusCode::INTERNAL_SERVER_ERROR, format!("Failed to save post: {}", e)).into_response();
    }

    info!("Created post with slug: {}", slug);
    Json(post).into_response()
}

#[instrument]
async fn update_post(
    Path(id): Path<String>,
    State(state): State<AppState>,
    Json(update_data): Json<UpdatePost>,
) -> impl IntoResponse {
    let mut posts = match state.posts.lock() {
        Ok(posts) => posts,
        Err(e) => {
            error!("Failed to acquire posts lock: {}", e);
            return (StatusCode::INTERNAL_SERVER_ERROR, "Database lock error").into_response();
        }
    };
    
    // Find the post by ID
    let post_to_update = posts.values().find(|post| post.id == id).cloned();
    
    if let Some(mut post) = post_to_update {
        let old_slug = post.slug.clone();
        
        // Update fields if provided
        if let Some(title) = update_data.title {
            post.title = title.clone();
            post.slug = title.to_lowercase().replace(' ', "-");
        }
        if let Some(content) = update_data.content {
            post.content = content;
        }
        if let Some(excerpt) = update_data.excerpt {
            post.excerpt = excerpt;
        }
        if let Some(author) = update_data.author {
            post.author = author;
        }
        if let Some(tags) = update_data.tags {
            post.tags = tags;
        }
        if let Some(image_url) = update_data.image_url {
            post.image_url = Some(image_url);
        }
        
        // Remove old entry and insert updated one
        posts.remove(&old_slug);
        posts.insert(post.slug.clone(), post.clone());
        
        // Save to JSON file
        if let Err(e) = save_posts_to_file(&posts) {
            error!("Failed to save posts: {}", e);
            return (StatusCode::INTERNAL_SERVER_ERROR, format!("Failed to update post: {}", e)).into_response();
        }
        
        info!("Updated post with id: {}", id);
        Json(post).into_response()
    } else {
        error!("Post not found with id: {}", id);
        (StatusCode::NOT_FOUND, "Post not found").into_response()
    }
}

#[instrument]
async fn delete_post(
    Path(id): Path<String>,
    State(state): State<AppState>,
) -> impl IntoResponse {
    let mut posts = match state.posts.lock() {
        Ok(posts) => posts,
        Err(e) => {
            error!("Failed to acquire posts lock: {}", e);
            return (StatusCode::INTERNAL_SERVER_ERROR, "Database lock error").into_response();
        }
    };
    
    // Find the post by ID and remove it
    let post_to_remove = posts.values().find(|post| post.id == id).cloned();
    
    if let Some(post) = post_to_remove {
        posts.remove(&post.slug);
        
        // Save to JSON file
        if let Err(e) = save_posts_to_file(&posts) {
            error!("Failed to save posts: {}", e);
            return (StatusCode::INTERNAL_SERVER_ERROR, format!("Failed to delete post: {}", e)).into_response();
        }
        
        info!("Deleted post with id: {}", id);
        (StatusCode::OK, "Post deleted successfully").into_response()
    } else {
        error!("Post not found with id: {}", id);
        (StatusCode::NOT_FOUND, "Post not found").into_response()
    }
}

fn save_posts_to_file(posts: &HashMap<String, Post>) -> Result<(), Box<dyn std::error::Error>> {
    let posts_vec: Vec<Post> = posts.values().cloned().collect();
    let json = serde_json::to_string_pretty(&posts_vec)?;
    fs::write("data/posts.json", json)?;
    Ok(())
}

fn load_posts_from_file() -> HashMap<String, Post> {
    // Try to load from data directory first, then fallback to current directory
    let paths = ["data/posts.json", "posts.json"];
    for path in &paths {
        if let Ok(content) = fs::read_to_string(path) {
            if let Ok(posts_vec) = serde_json::from_str::<Vec<Post>>(&content) {
                return posts_vec.into_iter().map(|post| (post.slug.clone(), post)).collect();
            }
        }
    }
    HashMap::new()
}

fn save_events_to_file(events: &HashMap<String, Event>) -> Result<(), Box<dyn std::error::Error>> {
    let events_vec: Vec<Event> = events.values().cloned().collect();
    let json = serde_json::to_string_pretty(&events_vec)?;
    fs::write("data/events.json", json)?;
    Ok(())
}

fn load_events_from_file() -> HashMap<String, Event> {
    // Try to load from data directory first, then fallback to current directory
    let paths = ["data/events.json", "events.json"];
    for path in &paths {
        if let Ok(content) = fs::read_to_string(path) {
            if let Ok(events_vec) = serde_json::from_str::<Vec<Event>>(&content) {
                return events_vec.into_iter().map(|event| (event.id.clone(), event)).collect();
            }
        }
    }
    HashMap::new()
}

fn determine_event_status(date: &str) -> String {
    let event_date = match chrono::NaiveDate::parse_from_str(date, "%Y-%m-%d") {
        Ok(date) => date,
        Err(_) => return "upcoming".to_string(),
    };
    
    let today = chrono::Local::now().date_naive();
    
    if event_date < today {
        "past".to_string()
    } else {
        "upcoming".to_string()
    }
}

// Save image locally for first 5 posts
async fn save_image_locally(image_data: &[u8], filename: &str) -> Result<String, Box<dyn std::error::Error + Send + Sync>> {
    // Create local images directory if it doesn't exist
    let local_images_dir = "static/images";
    if !StdPath::new(local_images_dir).exists() {
        fs::create_dir_all(local_images_dir)?;
    }
    
    let local_path = format!("{}/{}", local_images_dir, filename);
    fs::write(&local_path, image_data)?;
    
    Ok(format!("/static/images/{}", filename))
}

// Check if post is in the first 5 (most recent)
fn is_in_first_five_posts(posts: &HashMap<String, Post>, post_id: &str) -> bool {
    let mut posts_vec: Vec<&Post> = posts.values().collect();
    posts_vec.sort_by(|a, b| b.date.cmp(&a.date));
    
    posts_vec.iter().take(5).any(|post| post.id == post_id)
}

// Get posts with local image URLs for first 5 posts
fn get_posts_with_local_images(posts: &HashMap<String, Post>) -> Vec<Post> {
    let mut posts_vec: Vec<Post> = posts.values().cloned().collect();
    posts_vec.sort_by(|a, b| b.date.cmp(&a.date));
    
    // Update image URLs for first 5 posts to use local storage
    for (index, post) in posts_vec.iter_mut().enumerate() {
        if index < 5 && post.image_url.is_some() {
            let local_url = format!("/static/images/{}.jpg", post.id);
            // Check if local file exists
            if StdPath::new(&format!("static/images/{}.jpg", post.id)).exists() {
                post.image_url = Some(local_url);
            }
        }
    }
    
    posts_vec
}


async fn health_check() -> impl IntoResponse {
    "Rust Cameroon API is running!"
}

// Authentication functions
fn create_jwt_token(user_id: &str, secret: &str) -> Result<String, Box<dyn std::error::Error + Send + Sync>> {
    let now = Utc::now();
    let exp = now + Duration::hours(24); // Token expires in 24 hours
    
    let claims = Claims {
        sub: user_id.to_string(),
        exp: exp.timestamp() as usize,
        iat: now.timestamp() as usize,
        admin: true,
    };
    
    let token = encode(&Header::default(), &claims, &EncodingKey::from_secret(secret.as_ref()))?;
    Ok(token)
}

fn verify_jwt_token(token: &str, secret: &str) -> Result<Claims, Box<dyn std::error::Error + Send + Sync>> {
    let validation = Validation::new(Algorithm::HS256);
    let token_data = decode::<Claims>(token, &DecodingKey::from_secret(secret.as_ref()), &validation)?;
    Ok(token_data.claims)
}

fn hash_password(password: &str) -> String {
    let mut hasher = Sha256::new();
    hasher.update(password.as_bytes());
    let result = hasher.finalize();
    base64::engine::general_purpose::STANDARD.encode(result)
}

fn verify_password(password: &str, hashed: &str) -> bool {
    let hashed_input = hash_password(password);
    hashed_input == hashed
}

// IP whitelist check
fn is_ip_allowed(ip: &str, whitelist: &str) -> bool {
    if whitelist.is_empty() {
        return true; // No whitelist means all IPs allowed
    }
    
    let allowed_ips: Vec<&str> = whitelist.split(',').map(|s| s.trim()).collect();
    allowed_ips.contains(&ip)
}

// Authentication middleware
async fn auth_middleware(
    headers: HeaderMap,
    State(state): State<AppState>,
    request: Request,
    next: middleware::Next,
) -> Result<impl IntoResponse, StatusCode> {
    let path = request.uri().path();
    
    // Skip authentication for non-admin routes
    if !path.starts_with("/admin") && !path.starts_with("/posts") && !path.starts_with("/events") {
        return Ok(next.run(request).await);
    }
    
    // Skip authentication for login endpoint
    if path == "/admin/login" {
        return Ok(next.run(request).await);
    }
    
    // Get authorization header
    let auth_header = headers.get("Authorization");
    let token = match auth_header {
        Some(header) => {
            let header_str = header.to_str().unwrap_or("");
            if header_str.starts_with("Bearer ") {
                &header_str[7..]
            } else {
                return Err(StatusCode::UNAUTHORIZED);
            }
        }
        None => {
            return Err(StatusCode::UNAUTHORIZED);
        }
    };
    
    // Verify JWT token
    let claims = match verify_jwt_token(token, &state.config.jwt_secret) {
        Ok(claims) => claims,
        Err(_) => {
            return Err(StatusCode::UNAUTHORIZED);
        }
    };
    
    // Check if token is expired
    let now = Utc::now().timestamp() as usize;
    if claims.exp < now {
        return Err(StatusCode::UNAUTHORIZED);
    }
    
    // Check if user is admin
    if !claims.admin {
        return Err(StatusCode::FORBIDDEN);
    }
    
    // Continue to the next handler
    Ok(next.run(request).await)
}

// Login endpoint
#[instrument]
async fn admin_login(
    State(state): State<AppState>,
    headers: HeaderMap,
    Json(login_req): Json<LoginRequest>,
) -> impl IntoResponse {
    // Get client IP
    let client_ip = headers
        .get("x-forwarded-for")
        .or_else(|| headers.get("x-real-ip"))
        .and_then(|h| h.to_str().ok())
        .unwrap_or("unknown")
        .to_string();
    
    // Check IP whitelist
    if !is_ip_allowed(&client_ip, &state.config.admin_ip_whitelist) {
        warn!("Login attempt from non-whitelisted IP: {}", client_ip);
        return (StatusCode::FORBIDDEN, "Access denied from this IP").into_response();
    }
    
    // Verify password
    let hashed_password = hash_password(&state.config.admin_password);
    if !verify_password(&login_req.password, &hashed_password) {
        warn!("Failed login attempt from IP: {}", client_ip);
        return (StatusCode::UNAUTHORIZED, "Invalid credentials").into_response();
    }
    
    // Create JWT token
    let user_id = "admin".to_string();
    let token = match create_jwt_token(&user_id, &state.config.jwt_secret) {
        Ok(token) => token,
        Err(e) => {
            error!("Failed to create JWT token: {}", e);
            return (StatusCode::INTERNAL_SERVER_ERROR, "Failed to create token").into_response();
        }
    };
    
    // Create session
    let session = AdminSession {
        user_id: user_id.clone(),
        created_at: Utc::now(),
        last_activity: Utc::now(),
        ip_address: client_ip.clone(),
    };
    
    // Store session
    {
        let mut sessions = match state.sessions.lock() {
            Ok(sessions) => sessions,
            Err(_) => {
                error!("Failed to acquire sessions lock");
                return (StatusCode::INTERNAL_SERVER_ERROR, "Internal server error").into_response();
            }
        };
        sessions.insert(user_id.clone(), session);
    }
    
    info!("Admin login successful from IP: {}", client_ip);
    
    let response = LoginResponse {
        token,
        expires_in: 86400, // 24 hours in seconds
    };
    
    (StatusCode::OK, Json(response)).into_response()
}

// Logout endpoint
#[instrument]
async fn admin_logout(
    State(state): State<AppState>,
    headers: HeaderMap,
) -> impl IntoResponse {
    // Get authorization header
    let auth_header = headers.get("Authorization");
    let token = match auth_header {
        Some(header) => {
            let header_str = header.to_str().unwrap_or("");
            if header_str.starts_with("Bearer ") {
                &header_str[7..]
            } else {
                return (StatusCode::UNAUTHORIZED, "Invalid authorization header").into_response();
            }
        }
        None => {
            return (StatusCode::UNAUTHORIZED, "Missing authorization header").into_response();
        }
    };
    
    // Verify JWT token to get user ID
    let claims = match verify_jwt_token(token, &state.config.jwt_secret) {
        Ok(claims) => claims,
        Err(_) => {
            return (StatusCode::UNAUTHORIZED, "Invalid token").into_response();
        }
    };
    
    // Remove session
    {
        let mut sessions = match state.sessions.lock() {
            Ok(sessions) => sessions,
            Err(_) => {
                error!("Failed to acquire sessions lock");
                return (StatusCode::INTERNAL_SERVER_ERROR, "Internal server error").into_response();
            }
        };
        sessions.remove(&claims.sub);
    }
    
    info!("Admin logout successful for user: {}", claims.sub);
    
    (StatusCode::OK, "Logged out successfully").into_response()
}

// Event API handlers
#[instrument]
async fn get_events(State(state): State<AppState>) -> impl IntoResponse {
    let events_map = match state.events.lock() {
        Ok(events) => events,
        Err(_) => {
            error!("Failed to acquire events lock");
            return (StatusCode::INTERNAL_SERVER_ERROR, "Internal server error").into_response();
        }
    };
    
    let mut events_vec: Vec<Event> = events_map.values().cloned().collect();
    
    // Sort events by date (newest first)
    events_vec.sort_by(|a, b| b.date.cmp(&a.date));
    
    Json(events_vec).into_response()
}

#[instrument]
async fn get_upcoming_events(State(state): State<AppState>) -> impl IntoResponse {
    let events_map = match state.events.lock() {
        Ok(events) => events,
        Err(_) => {
            error!("Failed to acquire events lock");
            return (StatusCode::INTERNAL_SERVER_ERROR, "Internal server error").into_response();
        }
    };
    
    let mut upcoming_events: Vec<Event> = events_map
        .values()
        .filter(|event| event.status == "upcoming")
        .cloned()
        .collect();
    
    // Sort upcoming events by date (earliest first)
    upcoming_events.sort_by(|a, b| a.date.cmp(&b.date));
    
    Json(upcoming_events).into_response()
}

#[instrument]
async fn get_past_events(State(state): State<AppState>) -> impl IntoResponse {
    let events_map = match state.events.lock() {
        Ok(events) => events,
        Err(_) => {
            error!("Failed to acquire events lock");
            return (StatusCode::INTERNAL_SERVER_ERROR, "Internal server error").into_response();
        }
    };
    
    let mut past_events: Vec<Event> = events_map
        .values()
        .filter(|event| event.status == "past")
        .cloned()
        .collect();
    
    // Sort past events by date (newest first) and take only 5 most recent
    past_events.sort_by(|a, b| b.date.cmp(&a.date));
    past_events.truncate(5);
    
    Json(past_events).into_response()
}

#[instrument]
async fn create_event(
    State(state): State<AppState>,
    Json(new_event): Json<NewEvent>,
) -> impl IntoResponse {
    let id = uuid::Uuid::new_v4().to_string();
    let status = determine_event_status(&new_event.date);
    let created_at = chrono::Local::now().to_rfc3339();
    
    let event = Event {
        id: id.clone(),
        title: new_event.title,
        description: new_event.description,
        date: new_event.date,
        time: new_event.time,
        location: new_event.location,
        event_type: new_event.event_type,
        status,
        registration_url: new_event.registration_url,
        created_at,
    };
    
    let mut events_map = match state.events.lock() {
        Ok(events) => events,
        Err(_) => {
            error!("Failed to acquire events lock");
            return (StatusCode::INTERNAL_SERVER_ERROR, "Internal server error").into_response();
        }
    };
    
    events_map.insert(id.clone(), event.clone());
    
    if let Err(e) = save_events_to_file(&events_map) {
        error!("Failed to save events to file: {}", e);
        return (StatusCode::INTERNAL_SERVER_ERROR, "Failed to save event").into_response();
    }
    
    info!("Created new event: {}", id);
    (StatusCode::CREATED, Json(event)).into_response()
}

#[instrument]
async fn update_event(
    State(state): State<AppState>,
    Path(id): Path<String>,
    Json(update_event): Json<UpdateEvent>,
) -> impl IntoResponse {
    let mut events_map = match state.events.lock() {
        Ok(events) => events,
        Err(_) => {
            error!("Failed to acquire events lock");
            return (StatusCode::INTERNAL_SERVER_ERROR, "Internal server error").into_response();
        }
    };
    
    let mut event = match events_map.get(&id) {
        Some(event) => event.clone(),
        None => {
            return (StatusCode::NOT_FOUND, "Event not found").into_response();
        }
    };
    
    // Update fields if provided
    if let Some(title) = update_event.title {
        event.title = title;
    }
    if let Some(description) = update_event.description {
        event.description = description;
    }
    if let Some(date) = update_event.date {
        event.date = date.clone();
        event.status = determine_event_status(&date);
    }
    if let Some(time) = update_event.time {
        event.time = time;
    }
    if let Some(location) = update_event.location {
        event.location = location;
    }
    if let Some(event_type) = update_event.event_type {
        event.event_type = event_type;
    }
    if let Some(registration_url) = update_event.registration_url {
        event.registration_url = Some(registration_url);
    }
    
    events_map.insert(id.clone(), event.clone());
    
    if let Err(e) = save_events_to_file(&events_map) {
        error!("Failed to save events to file: {}", e);
        return (StatusCode::INTERNAL_SERVER_ERROR, "Failed to save event").into_response();
    }
    
    info!("Updated event: {}", id);
    Json(event).into_response()
}

#[instrument]
async fn delete_event(
    State(state): State<AppState>,
    Path(id): Path<String>,
) -> impl IntoResponse {
    let mut events_map = match state.events.lock() {
        Ok(events) => events,
        Err(_) => {
            error!("Failed to acquire events lock");
            return (StatusCode::INTERNAL_SERVER_ERROR, "Internal server error").into_response();
        }
    };
    
    if events_map.remove(&id).is_none() {
        return (StatusCode::NOT_FOUND, "Event not found").into_response();
    }
    
    if let Err(e) = save_events_to_file(&events_map) {
        error!("Failed to save events to file: {}", e);
        return (StatusCode::INTERNAL_SERVER_ERROR, "Failed to save events").into_response();
    }
    
    info!("Deleted event: {}", id);
    (StatusCode::NO_CONTENT, ()).into_response()
}

#[tokio::main]
async fn main() {
    // Load configuration from environment variables
    let config = match Config::init_from_env() {
        Ok(config) => {
            info!("Configuration loaded successfully");
            config
        }
        Err(e) => {
            error!("Failed to load configuration: {}", e);
            std::process::exit(1);
        }
    };

    // Initialize logging with configured level
    tracing_subscriber::fmt()
        .with_max_level(tracing::Level::INFO)
        .init();

    // Load posts from file
    let posts_storage = PostsStorage::new(std::sync::Mutex::new(load_posts_from_file()));
    
    // Load events from file
    let events_storage = EventsStorage::new(std::sync::Mutex::new(load_events_from_file()));
    
    // Initialize sessions storage
    let sessions_storage = SessionsStorage::new(std::sync::Mutex::new(HashMap::new()));

    // Initialize MinIO service
    let minio_service = match MinioService::new(&config).await {
        Ok(service) => {
            info!("MinIO service initialized successfully");
            service
        }
        Err(e) => {
            error!("Failed to initialize MinIO service: {}", e);
            std::process::exit(1);
        }
    };

    // Create combined application state
    let app_state = AppState {
        posts: posts_storage,
        events: events_storage,
        sessions: sessions_storage,
        minio: minio_service,
        config: config.clone(),
    };

    let cors = CorsLayer::new()
        .allow_methods(Any)
        .allow_origin(Any)
        .allow_headers(Any);

    // Rate limiting configuration (disabled for now)
    // let governor_conf = GovernorConfigBuilder::default()
    //     .per_second(10)
    //     .burst_size(20)
    //     .finish()
    //     .unwrap();

    let app = Router::new()
        .route("/", get(health_check))
        // Public routes (no authentication required)
        .route("/posts", get(get_posts))
        .route("/posts/slug/:slug", get(get_post))
        .route("/events", get(get_events))
        .route("/events/upcoming", get(get_upcoming_events))
        .route("/events/past", get(get_past_events))
        // Admin authentication routes
        .route("/admin/login", post(admin_login))
        .route("/admin/logout", post(admin_logout))
        // Protected admin routes (require authentication)
        .route("/posts", post(create_post))
        .route("/posts/update/:id", put(update_post))
        .route("/posts/delete/:id", delete(delete_post))
        .route("/events", post(create_event))
        .route("/events/update/:id", put(update_event))
        .route("/events/delete/:id", delete(delete_event))
        .nest_service("/static", ServeDir::new("static"))
        .layer(
            ServiceBuilder::new()
                .layer(TraceLayer::new_for_http())
                .layer(cors)
                .layer(middleware::from_fn_with_state(app_state.clone(), auth_middleware)),
        )
        .with_state(app_state);

    let socket = format!("0.0.0.0:{}", config.port);
    
    info!("Server starting on {}", socket);
    
    let listener = tokio::net::TcpListener::bind(socket).await.unwrap();
    axum::serve(listener, app).await.unwrap();
}