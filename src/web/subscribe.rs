use axum::{http::StatusCode, response::{IntoResponse, Redirect, Response}, Extension, Json};
use serde::Deserialize;
use serde_json::Value;

use crate::{auth::{authentication::{send_otp, subscriber_validation}, errors::SubscriptionError}, database::queries::{Database, Otp}};

use super::errors::error_page;

#[derive(Debug, Deserialize)]
pub struct Subscription {
    email: String
}

pub async fn post_subscribe(
    Extension(otp): Extension<Otp>,
 mut database: Extension<Database>,
 Json(subscriber): Json<Subscription>
) -> impl IntoResponse {
    match subscriber_validation(&mut database, &subscriber.email).await {
        Ok(_) => {
let _ = send_otp(otp.value, &subscriber.email);

let _ = Redirect::to("/verify_otp");
            StatusCode::ACCEPTED.into_response()},
        Err(e) => error_page(&e).into_response()
    }
}
async fn post_verify_otp(otp: Json<Otp>) {
let totp = Otp::new
}