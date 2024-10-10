use axum::{http::{Response, StatusCode}, response::IntoResponse};
use lettre::{transport::smtp::authentication::Credentials, Message, SmtpTransport, Transport};

use crate::database::queries::{get_subscriber, Database, Otp};

use super::errors::SubscriptionError;

pub async fn subscriber_validation(connection: &mut Database, email: &String) -> Result<(), SubscriptionError> {
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
pub async fn new_otp() -> String{
    Otp::generate_new()
}
pub fn send_otp(otp: String, email: &String) -> Result<StatusCode, StatusCode> {
    let email = Message::builder()
        .from("yemelechrristian2@gmail.com".parse().unwrap())
        .reply_to("to@example.com".parse().unwrap())
        .to(email.parse().unwrap())
        .subject("Rust Email")
        .body(otp)
        .unwrap();

    // Set up the SMTP client
    let creds = Credentials::new("d006ed6ea804b3".to_string(), "25553583d3558b".to_string());
    // Open a remote connection to gmail

    let mailer = SmtpTransport::starttls_relay("sandbox.smtp.mailtrap.io")
        .unwrap()
        .credentials(creds)
        .build();
    match mailer.send(&email) {
        Ok(_) => Ok(StatusCode::OK),
        Err(_) => Err(StatusCode::INTERNAL_SERVER_ERROR),
    }
}
