use axum::{response::IntoResponse, Extension, Json};

use crate::{
    database::{self, queries::Database},
    web::errors::error_page,
};

pub async fn get_posts_(mut database: Extension<Database>) -> impl IntoResponse {
    let posts = match database::queries::get_posts(&mut database).await {
        Ok(posts) => posts,
        Err(e) => {
            tracing::error!("Failed to get posts: {:?}", e);
            return error_page(&e).into_response();
        }
    };
    Json(posts).into_response()
}

pub async fn add_post(
    mut database: Extension<Database>,
    Json(post): Json<database::model::NewPost>,
) -> impl IntoResponse {
    match database::queries::add_post(&mut database, post).await {
        Ok(_) => (),
        Err(e) => {
            tracing::error!("Failed to create post: {:?}", e);
            return error_page(&e).into_response();
        }
    };
    // Return a 201 Created response.
    axum::http::StatusCode::CREATED.into_response()
}
