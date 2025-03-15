use axum::http::StatusCode;
use lettre::{
    message::MessageBuilder, transport::smtp::authentication::Credentials, Message, SmtpTransport,
    Transport,
};

use crate::database::queries::{get_subscriber, subscribe, Database, Otp};

use super::errors::SubscriptionError;

pub async fn subscriber_validation(
    connection: &mut Database,
    email: &String,
) -> Result<(), SubscriptionError> {
    if !email.ends_with("@gmail.com") {
        Err(SubscriptionError::InvalidEmail)?
    }
    if get_subscriber(connection, &email)
        .await
        .is_ok_and(|subscriber| subscriber.is_some())
    {
        Err(SubscriptionError::EmailSubscribed)?
    } else {
        Ok(())
    }
}
pub fn new_otp() -> String {
    Otp::generate_new()
}
pub fn send_otp(otp: String, email: &String) -> Result<StatusCode, SubscriptionError> {
    let from = std::env::var("EMAIL_FROM").unwrap_or("hello@darma.segning.pro".to_string());
    let reply_to = std::env::var("EMAIL_REPLY_TO").unwrap_or("hello@darma.segning.pro".to_string());

    let email = Message::builder()
        .from(from.parse().map_err(|e| {
            tracing::error!("Error parsing email: {:?}", e);
            SubscriptionError::InternalError
        })?)
        .reply_to(reply_to.parse().map_err(|e| {
            tracing::error!("Error parsing email: {:?}", e);
            SubscriptionError::InternalError
        })?)
        .to(email.parse().map_err(|_| SubscriptionError::InvalidEmail)?)
        .subject("Verification Email")
        .body(otp)
        .map_err(|e| SubscriptionError::Generic(e.to_string()));

    // Set up the SMTP client
    let creds = Credentials::new(
        "smtp@mailtrap.io".to_string(),
        "a5814b78ae16cd6514fcdcf506b7b86e".to_string(),
    );
    // Open a remote connection to gmail

    let mailer = SmtpTransport::starttls_relay("bulk.smtp.mailtrap.io")
        .unwrap()
        .credentials(creds)
        .build();
    if let Some(email) = email.ok() {
        match mailer.send(&email) {
            Ok(_) => Ok(StatusCode::OK),
            Err(_) => Err(SubscriptionError::MailError),
        }
    } else {
        Err(SubscriptionError::InternalError)
    }
}

pub async fn auth_verify_otp(
    otp: String,
    conn: &mut Database,
    email_addr: String,
) -> Result<(), SubscriptionError> {
    let totp = Otp::new();
    let result = totp
        .check_current(&otp)
        .map_err(|_| SubscriptionError::InternalError)?;
    if result {
        match subscribe(conn, email_addr)
            .await
            .map_err(|_| SubscriptionError::DatabaseError)
        {
            Ok(_) => Ok(()),
            Err(e) => Err(e),
        }
    } else {
        Err(SubscriptionError::OtpError)
    }
}
