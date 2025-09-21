use axum::{
    extract::Path,
    http::StatusCode,
    response::IntoResponse,
    routing::{get, post, delete},
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
use tracing_subscriber;

#[derive(Debug, Serialize, Deserialize, Clone)]
pub struct Post {
    pub id: String,
    pub title: String,
    pub content: String,
    pub excerpt: String,
    pub author: String,
    pub date: String,
    pub tags: Vec<String>,
    pub image_url: Option<String>,
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

// In-memory storage for posts (in production, use a database)
type PostsStorage = std::sync::Arc<std::sync::Mutex<HashMap<String, Post>>>;

async fn get_posts(posts: axum::extract::State<PostsStorage>) -> impl IntoResponse {
    let posts = posts.lock().unwrap();
    let posts_vec: Vec<Post> = posts.values().cloned().collect();
    Json(posts_vec)
}

async fn get_post(
    Path(slug): Path<String>,
    posts: axum::extract::State<PostsStorage>,
) -> impl IntoResponse {
    let posts = posts.lock().unwrap();
    match posts.get(&slug) {
        Some(post) => Json(post.clone()).into_response(),
        None => (StatusCode::NOT_FOUND, "Post not found").into_response(),
    }
}

async fn create_post(
    posts: axum::extract::State<PostsStorage>,
    Json(new_post): Json<NewPost>,
) -> impl IntoResponse {
    let slug = new_post.title.to_lowercase().replace(' ', "-");
    let post = Post {
        id: uuid::Uuid::new_v4().to_string(),
        slug: slug.clone(),
        date: chrono::Utc::now().format("%Y-%m-%d").to_string(),
        title: new_post.title,
        content: new_post.content,
        excerpt: new_post.excerpt,
        author: new_post.author,
        tags: new_post.tags,
        image_url: new_post.image_url,
    };

    let mut posts = posts.lock().unwrap();
    posts.insert(slug.clone(), post.clone());
    
    // Save to JSON file
    if let Err(e) = save_posts_to_file(&posts) {
        tracing::error!("Failed to save posts: {}", e);
        return (StatusCode::INTERNAL_SERVER_ERROR, "Failed to save post").into_response();
    }

    (StatusCode::CREATED, Json(post)).into_response()
}

async fn delete_post(
    Path(id): Path<String>,
    posts: axum::extract::State<PostsStorage>,
) -> impl IntoResponse {
    let mut posts = posts.lock().unwrap();
    
    // Find the post by ID and remove it
    let post_to_remove = posts.values().find(|post| post.id == id).cloned();
    
    if let Some(post) = post_to_remove {
        posts.remove(&post.slug);
        
        // Save to JSON file
        if let Err(e) = save_posts_to_file(&posts) {
            tracing::error!("Failed to save posts: {}", e);
            return (StatusCode::INTERNAL_SERVER_ERROR, "Failed to delete post").into_response();
        }
        
        (StatusCode::OK, "Post deleted successfully").into_response()
    } else {
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

    let cors = CorsLayer::new()
        .allow_methods(Any)
        .allow_origin(Any)
        .allow_headers(Any);

    let app = Router::new()
        .route("/", get(health_check))
        .route("/api/posts", get(get_posts).post(create_post))
        .route("/api/posts/:slug", get(get_post))
        .route("/api/posts/delete/:id", delete(delete_post))
        .nest_service("/static", ServeDir::new("static"))
        .layer(
            ServiceBuilder::new()
                .layer(TraceLayer::new_for_http())
                .layer(cors),
        )
        .with_state(posts_storage);

    let port = std::env::var("PORT").unwrap_or_else(|_| "8000".to_string());
    let socket = format!("0.0.0.0:{}", port);
    
    tracing::info!("Server starting on {}", socket);
    
    let listener = tokio::net::TcpListener::bind(socket).await.unwrap();
    axum::serve(listener, app).await.unwrap();
}