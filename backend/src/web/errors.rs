use axum::{http::{Response, StatusCode}, response::IntoResponse};

pub fn error_page(e: &dyn std::error::Error) -> impl IntoResponse {
    Response::builder()
        .status(StatusCode::INTERNAL_SERVER_ERROR)
        .body(format!("{}", e))
        .unwrap()
}
