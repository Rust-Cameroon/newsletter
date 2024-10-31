use std::{
    borrow::Borrow,
    f32::consts::E,
    sync::{Arc, Mutex},
    time::SystemTimeError,
};

use axum::{
    debug_handler,
    http::StatusCode,
    response::{IntoResponse, Redirect, Response},
    Extension, Json,
};
use serde::{de::value::EnumAccessDeserializer, Deserialize};

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
#[axum::debug_handler]
pub async fn post_subscribe(
    Extension(otp): Extension<EmailOtp>,
    Extension(email): Extension<Arc<Mutex<String>>>,
    mut database: Extension<Database>,
    Json(subscriber): Json<Subscription>,
) -> impl IntoResponse {
    match subscriber_validation(&mut database, &subscriber.email).await {
        Ok(_) => {
            let _ = send_otp(otp.code, &subscriber.email).into_response();

            *email.lock().unwrap() = subscriber.email;

            let _ = Redirect::to("/verify_otp");
            StatusCode::ACCEPTED.into_response()
        }
        Err(e) => error_page(&e).into_response(),
    }
}
#[axum::debug_handler]
pub async fn post_verify_email(
    mut database: Extension<Database>,
    email: Extension<Arc<Mutex<String>>>,
    otp: Json<EmailOtp>,
) -> impl IntoResponse {
    let email = email.0.lock().unwrap().clone();
    match auth_verify_otp(otp.code.clone(), &mut database, email).await {
        Ok(_) => StatusCode::ACCEPTED.into_response(),
        Err(e) => e.json().into_response(),
    }
}
