use super::errors::SubscriptionError;

pub async fn subscribe(email: String) -> Result<(), SubscriptionError > {
    if !email.ends_with("@gmail.com") {
        Err(SubscriptionError::InvalidEmail)?
    }
    


}