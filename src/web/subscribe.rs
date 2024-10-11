use std::time::SystemTimeError;

use axum::{
    debug_handler, http::StatusCode, response::{IntoResponse, Redirect, Response}, Extension, Json
};
use serde::Deserialize;

use crate::{
    auth::authentication::{auth_verify_otp, send_otp, subscriber_validation},
    database::queries::{subscribe, Database, Otp},
};

use super::errors::error_page;

#[derive(Debug, Deserialize)]
pub struct Subscription {
    email: String,
}
#[derive(Clone, Deserialize)]
pub struct EmailOtp {
    pub code: String,
}

pub async fn post_subscribe(
    Extension(otp): Extension<EmailOtp>,
    Extension(mut email): Extension<String>,
    mut database: Extension<Database>,
    Json(subscriber): Json<Subscription>,
) -> impl IntoResponse {
    match subscriber_validation(&mut database, &subscriber.email).await {
        Ok(_) => {
            let _ = send_otp(otp.code, &subscriber.email).into_response();

            email.clear();
            email.push_str(&subscriber.email);
            //    let _ = Redirect::to("/verify_otp");
            StatusCode::ACCEPTED.into_response()
        }
        Err(e) => error_page(&e).into_response(),
    }
}
#[axum::debug_handler]
pub async fn post_verify_email(
    mut database: Extension<Database>,
    email: Extension<String>,
    otp: Json<EmailOtp>,
) -> impl IntoResponse {
    match auth_verify_otp(otp.code.clone(), &mut database, email.0).await {
        Ok(_) => StatusCode::ACCEPTED.into_response(),
        Err(e) => e.json().into_response(),
    }
}
