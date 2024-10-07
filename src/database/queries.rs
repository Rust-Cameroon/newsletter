use totp_rs::{Algorithm, Secret, TOTP};
use diesel::{prelude::*, result::Error};

use super::schema::subscribers;
pub struct Otp;

type Database = PgConnection;
impl Otp {
    pub fn generate_new() -> String {
        let totp = TOTP::new(
            Algorithm::SHA1,
            6,
            1,
            20,
            Secret::Encoded("KRSXG5CTMVRXEZLUKN2XAZLSKNSWG4TFOQ".to_string())
                .to_bytes()
                .unwrap(),
        )
        .unwrap();
      totp.generate_current().unwrap()
     
    }
    pub fn new() -> TOTP {
        let totp = TOTP::new(
            Algorithm::SHA1,
            6,
            1,
            20,
            Secret::Encoded("KRSXG5CTMVRXEZLUKN2XAZLSKNSWG4TFOQ".to_string())
                .to_bytes()
                .unwrap(),
        )
        .unwrap();
    totp
    }
    
}
pub async fn subscribe(
    conn: &Database,
    email: String
) -> Result<(), Error>
{
    diesel::insert_into(subscribers::table)
    .values("")
    .returning(Post::as_returning())
    .get_result(conn)
    .expect("Error saving new post")
}