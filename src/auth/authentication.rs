use crate::database::queries::{get_subscriber, Database};

use super::errors::SubscriptionError;

pub async fn subscriber_validation(connection: &mut Database, email: String) -> Result<(), SubscriptionError> {
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
 