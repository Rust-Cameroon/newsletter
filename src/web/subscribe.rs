use axum::{response::IntoResponse, Extension, Json};
use serde::Deserialize;

use crate::database::queries::Database;

#[derive(Debug, Deserialize)]
pub struct Subscription {
    email: String
}

pub fn post_subscribe(
 database: Extension<Database>,
 Json(subscriber): Json<Subscription>
) -> impl IntoResponse {
    
}
