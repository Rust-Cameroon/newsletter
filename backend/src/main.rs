use axum::{
    extract::{Path, Multipart, State},
    http::StatusCode,
    response::IntoResponse,
    routing::{get, post, delete, put},
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
use aws_config::meta::region::RegionProviderChain;
use bytes::Bytes;

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

// In-memory storage for posts (in production, use a database)
type PostsStorage = std::sync::Arc<std::sync::Mutex<HashMap<String, Post>>>;

// Combined application state
#[derive(Clone, Debug)]
struct AppState {
    posts: PostsStorage,
    minio: MinioService,
}

// MinIO client wrapper using AWS SDK
#[derive(Clone, Debug)]
struct MinioService {
    client: S3Client,
    bucket: String,
    endpoint: String,
}

impl MinioService {
    async fn new() -> Result<Self, Box<dyn std::error::Error + Send + Sync>> {
        let endpoint = std::env::var("MINIO_ENDPOINT").unwrap_or_else(|_| "http://localhost:9000".to_string());
        let access_key = std::env::var("MINIO_ACCESS_KEY").unwrap_or_else(|_| "minioadmin".to_string());
        let secret_key = std::env::var("MINIO_SECRET_KEY").unwrap_or_else(|_| "minioadmin123".to_string());
        let bucket = std::env::var("MINIO_BUCKET").unwrap_or_else(|_| "rust-cameroon-images".to_string());

        info!("Initializing MinIO service with endpoint: {}", endpoint);
        info!("MinIO access key: {}", access_key);
        info!("MinIO bucket: {}", bucket);

        // Retry logic for MinIO connection
        let mut retries = 0;
        let max_retries = 10;
        let retry_delay = std::time::Duration::from_secs(2);

        loop {
            match Self::try_connect(&endpoint, &access_key, &secret_key, &bucket).await {
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
        bucket: &str,
    ) -> Result<Self, Box<dyn std::error::Error + Send + Sync>> {
        // Configure AWS SDK for MinIO
        let region_provider = RegionProviderChain::default_provider().or_else("us-east-1");
        let config = aws_config::defaults(aws_config::BehaviorVersion::latest())
            .region(region_provider)
            .endpoint_url(endpoint)
            .credentials_provider(aws_sdk_s3::config::Credentials::new(
                access_key,
                secret_key,
                None,
                None,
                "minio",
            ))
            .load()
            .await;

        let client = S3Client::new(&config);

        let service = MinioService { 
            client, 
            bucket: bucket.to_string(),
            endpoint: endpoint.to_string(),
        };
        
        // Ensure bucket exists
        service.ensure_bucket_exists().await?;
        
        Ok(service)
    }

    async fn ensure_bucket_exists(&self) -> Result<(), Box<dyn std::error::Error + Send + Sync>> {
        match self.client.head_bucket().bucket(&self.bucket).send().await {
            Ok(_) => {
                info!("MinIO bucket exists: {}", self.bucket);
            }
            Err(_) => {
                // Bucket doesn't exist, create it
                self.client
                    .create_bucket()
                    .bucket(&self.bucket)
                    .send()
                    .await?;
                info!("Created MinIO bucket: {}", self.bucket);
            }
        }

        Ok(())
    }

    async fn upload_file(&self, filename: &str, data: Bytes) -> Result<String, Box<dyn std::error::Error + Send + Sync>> {
        let object_name = format!("{}/{}", chrono::Utc::now().format("%Y/%m/%d"), filename);
        
        self.client
            .put_object()
            .bucket(&self.bucket)
            .key(&object_name)
            .body(data.into())
            .send()
            .await?;

        // Return URL that will be served through nginx proxy
        let url = format!("https://rustcameroon.com/minio/{}/{}", self.bucket, object_name);

        Ok(url)
    }
}

#[instrument]
async fn get_posts(State(state): State<AppState>) -> impl IntoResponse {
    let posts = state.posts.lock().unwrap();
    let posts_vec: Vec<Post> = posts.values().cloned().collect();
    info!("Fetched all posts");
    Json(posts_vec)
}

#[instrument]
async fn get_post(
    Path(slug): Path<String>,
    State(state): State<AppState>,
) -> impl IntoResponse {
    let posts = state.posts.lock().unwrap();
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
    while let Some(field) = multipart.next_field().await.unwrap() {
        if let Some(name) = field.name() {
            match name {
                "file" => {
                    // Handle file upload
                    if let Some(filename) = field.file_name() {
                        let filename = filename.to_string();
                        let data = field.bytes().await.unwrap();
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

    let mut posts = state.posts.lock().unwrap();
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
    let mut posts = state.posts.lock().unwrap();
    
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
    let mut posts = state.posts.lock().unwrap();
    
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
    fs::write("posts.json", json)?;
    Ok(())
}

fn load_posts_from_file() -> HashMap<String, Post> {
    if let Ok(content) = fs::read_to_string("posts.json") {
        if let Ok(posts_vec) = serde_json::from_str::<Vec<Post>>(&content) {
            return posts_vec.into_iter().map(|post| (post.slug.clone(), post)).collect();
        }
    }
    HashMap::new()
}


async fn health_check() -> impl IntoResponse {
    "Rust Cameroon API is running!"
}

#[tokio::main]
async fn main() {
    tracing_subscriber::fmt()
        .with_max_level(tracing::Level::INFO)
        .init();

    // Load posts from file
    let posts_storage = PostsStorage::new(std::sync::Mutex::new(load_posts_from_file()));

    // Initialize MinIO service
    let minio_service = match MinioService::new().await {
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
        minio: minio_service,
    };

    let cors = CorsLayer::new()
        .allow_methods(Any)
        .allow_origin(Any)
        .allow_headers(Any);

    let app = Router::new()
        .route("/", get(health_check))
        .route("/posts", get(get_posts).post(create_post))
        .route("/posts/:slug", get(get_post))
        .route("/posts/:id", put(update_post))
        .route("/posts/delete/:id", delete(delete_post))
        .nest_service("/static", ServeDir::new("static"))
        .layer(
            ServiceBuilder::new()
                .layer(TraceLayer::new_for_http())
                .layer(cors),
        )
        .with_state(app_state);

    let port = std::env::var("PORT").unwrap_or_else(|_| "8000".to_string());
    let socket = format!("0.0.0.0:{}", port);
    
    info!("Server starting on {}", socket);
    
    let listener = tokio::net::TcpListener::bind(socket).await.unwrap();
    axum::serve(listener, app).await.unwrap();
}