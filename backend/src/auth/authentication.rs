use axum::
    http::StatusCode
;
use lettre::{transport::smtp::authentication::Credentials, Message, SmtpTransport, Transport};


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
    let email = Message::builder()
        .from("hello@darma.segning.pro".parse().unwrap())
        .reply_to("hello@darma.segning.pro".parse().unwrap())
        .to(email.parse().map_err(|_| SubscriptionError::InvalidEmail)?)
        .subject("Verification Email")
        .body(otp)
        .unwrap();

    // Set up the SMTP client
    let creds = Credentials::new("smtp@mailtrap.io".to_string(), "a5814b78ae16cd6514fcdcf506b7b86e".to_string());
    // Open a remote connection to gmail

    let mailer = SmtpTransport::starttls_relay("bulk.smtp.mailtrap.io")
        .unwrap()
        .credentials(creds)
        .build();
    match mailer.send(&email) {
        Ok(_) => Ok(StatusCode::OK),
        Err(_) => Err(SubscriptionError::MailError),
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
