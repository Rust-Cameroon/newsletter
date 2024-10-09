use diesel::{prelude::*, result::Error};
use totp_rs::{Algorithm, Secret, TOTP};

use crate::database::model::Subcriber;

use super::{
    model::NewSubscriber, schema::{self, subscribers}}
;
pub struct Otp;

pub type Database = PgConnection;
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
pub async fn subscribe(conn: &mut Database, email_addr: String) -> Result<usize, Error> {
    let new_sub = NewSubscriber { email: email_addr };
    diesel::insert_into(subscribers::table)
        .values(new_sub)
        .execute(&mut *conn)
}
pub async fn unsubscribe(
    conn: &mut Database,
    mail_addr: String,
) -> Result<usize, diesel::result::Error> {
    use schema::subscribers::dsl::*;
    let conn = conn;
    diesel::delete(subscribers.filter(email.like(mail_addr))).execute(&mut *conn)
}
pub async fn get_subscriber(
    conn: &mut Database,
    email_addr: &String,
) -> Result<Option<Subcriber>, diesel::result::Error> {
    use schema::subscribers::dsl::*;
    let conn = conn;
    let result = subscribers
        .filter(email.eq(email_addr))
        .select(Subcriber::as_select())
        .first(&mut *conn)?;

    Ok(Some(result))
}