use axum::Json;
use serde_json::{json, Value};
use thiserror::Error;

#[derive(Debug, Error)]
pub enum SubscriptionError {
    #[error("Invalid email")]
    InvalidEmail,
    #[error("Email addresse already subscribed")]
    EmailSubscribed,
    #[error("Invalid Code")]
    InvalidCode,
    #[error("Internal Error")]
    InternalError,
    #[error("Error storing subscruber")]
    DatabaseError,
    #[error("could not send otp")]
    MailError,
    #[error("Invalid OTP")]
    OtpError
}
impl SubscriptionError {
    /// Converts the error to an axum JSON representation.
    pub fn json(&self) -> Json<Value> {
        Json({
            json!(self.to_string())
        })
    }
}
