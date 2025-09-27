use axum::{
    extract::{Path, Multipart, State},
    http::StatusCode,
    response::IntoResponse,
    routing::{get, delete, put},
    Json, Router,
};
use serde::{Deserialize, Serialize};
use std::collections::HashMap;
use std::fs;
use tower::ServiceBuilder;
use tower_http::{
    cors::{Any, CorsLayer},
    services::ServeDir,
    trace::TraceLayer,
};
use tracing::{info, error, instrument};
use tracing_subscriber;
use aws_sdk_s3::Client as S3Client;
use bytes::Bytes;
use envconfig::Envconfig;

#[derive(Envconfig)]
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

// Combined application state
#[derive(Clone, Debug)]
struct AppState {
    posts: PostsStorage,
    events: EventsStorage,
    minio: MinioService,
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
    let posts_vec: Vec<Post> = posts.values().cloned().collect();
    info!("Fetched all posts");
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
                        match state.minio.upload_file(&filename, data).await {
                            Ok(url) => {
                                let url_clone = url.clone();
                                image_url = Some(url);
                                info!("Uploaded image: {} -> {}", filename, url_clone);
                            }
                            Err(e) => {
                                error!("Failed to upload image: {}", e);
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


async fn health_check() -> impl IntoResponse {
    "Rust Cameroon API is running!"
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
        minio: minio_service,
    };

    let cors = CorsLayer::new()
        .allow_methods(Any)
        .allow_origin(Any)
        .allow_headers(Any);

    let app = Router::new()
        .route("/", get(health_check))
        .route("/posts", get(get_posts).post(create_post))
        .route("/posts/slug/:slug", get(get_post))
        .route("/posts/update/:id", put(update_post))
        .route("/posts/delete/:id", delete(delete_post))
        .route("/events", get(get_events).post(create_event))
        .route("/events/upcoming", get(get_upcoming_events))
        .route("/events/past", get(get_past_events))
        .route("/events/update/:id", put(update_event))
        .route("/events/delete/:id", delete(delete_event))
        .nest_service("/static", ServeDir::new("static"))
        .layer(
            ServiceBuilder::new()
                .layer(TraceLayer::new_for_http())
                .layer(cors),
        )
        .with_state(app_state);

    let socket = format!("0.0.0.0:{}", config.port);
    
    info!("Server starting on {}", socket);
    
    let listener = tokio::net::TcpListener::bind(socket).await.unwrap();
    axum::serve(listener, app).await.unwrap();
}