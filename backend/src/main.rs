use axum::{
    response::IntoResponse,
    routing::{get, post},
    Extension, Router,
};
use newsletter::{
    auth::authentication::new_otp,
    database::{connection::establish_connection, queries::get_posts},
    web::{
        posts::{add_post, get_posts_},
        subscribe::{post_subscribe, post_verify_email, EmailOtp},
    },
};
use std::sync::{Arc, Mutex};
use tokio::net::TcpListener;
use tower::ServiceBuilder;
use tower_http::{
    cors::{Any, CorsLayer},
    trace::TraceLayer,
};

async fn welcome() -> impl IntoResponse {
    "Welcome To Rust Cameroon"
}
#[tokio::main]
async fn main() {
    tracing_subscriber::fmt()
        .with_max_level(tracing::Level::DEBUG)
        .init();

    let db_connection = establish_connection().await;

    let otp = new_otp();

    let cors = CorsLayer::new()
        .allow_methods(Any)
        .allow_origin(Any)
        .allow_headers(Any);

    let email = Arc::new(Mutex::new(String::new()));
    let code = EmailOtp { code: otp };
    let port = 8000;
    let socket = format!("0.0.0.0:{}", port);
    let listener = TcpListener::bind(socket).await.unwrap();
    let router = Router::new()
        .route("/", get(welcome))
        .route("/subscribe", post(post_subscribe))
        .route("/posts", get(get_posts_).post(add_post))
        .route("/verify_otp", post(post_verify_email))
        .layer(
            ServiceBuilder::new()
                .layer(TraceLayer::new_for_http())
                .layer(cors)
                .layer(Extension(email))
                .layer(Extension(code))
                .layer(Extension(db_connection)),
        );
    axum::serve(listener, router).await.unwrap();
}
