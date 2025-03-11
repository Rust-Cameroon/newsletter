use diesel::{prelude::*, result::Error};
use diesel_async::{pooled_connection::deadpool::Pool, AsyncPgConnection, RunQueryDsl};
use totp_rs::{Algorithm, Secret, TOTP};

use crate::database::model::Subcriber;

use super::{
    model::{NewPost, NewSubscriber, Post},
    schema::{
        self,
        posts::{self, table},
        subscribers,
    },
};
pub struct Otp;

pub type Database = Pool<AsyncPgConnection>;
impl Otp {
    pub fn generate_new() -> String {
        let totp = TOTP::new(
            Algorithm::SHA1,
            6,
            1,
            30,
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
            30,
            Secret::Encoded("KRSXG5CTMVRXEZLUKN2XAZLSKNSWG4TFOQ".to_string())
                .to_bytes()
                .unwrap(),
        )
        .unwrap();
        totp
    }
}
pub async fn subscribe(conn: &Database, email_addr: String) -> Result<usize, Error> {
    let mut conn = conn.get().await.unwrap();
    let new_sub = NewSubscriber { email: email_addr };
    diesel::insert_into(subscribers::table)
        .values(new_sub)
        .execute(&mut *conn)
        .await
}
pub async fn unsubscribe(
    conn: &mut Database,
    mail_addr: String,
) -> Result<usize, diesel::result::Error> {
    let mut conn = conn.get().await.unwrap();
    use schema::subscribers::dsl::*;
    diesel::delete(subscribers.filter(email.like(mail_addr)))
        .execute(&mut *conn)
        .await
}
pub async fn get_subscriber(
    conn: &mut Database,
    email_addr: &String,
) -> Result<Option<Subcriber>, diesel::result::Error> {
    use schema::subscribers::dsl::*;
    let mut conn = conn.get().await.unwrap();
    let result = subscribers
        .filter(email.eq(email_addr))
        .select(Subcriber::as_select())
        .first(&mut *conn)
        .await?;

    Ok(Some(result))
}

pub async fn get_posts(conn: &mut Database) -> Result<Vec<Post>, Error> {
    let mut conn = conn
        .get()
        .await
        .map_err(|e| Error::QueryBuilderError(e.to_string().into()))?;
    let post_list = posts::table
        .select(Post::as_select())
        .load::<Post>(&mut *conn)
        .await
        .map_err(|e| Error::QueryBuilderError(e.to_string().into()))?;
    Ok(post_list)
}

pub async fn add_post(conn: &mut Database, post: NewPost) -> Result<bool, Error> {
    let mut conn = conn
        .get()
        .await
        .map_err(|e| Error::QueryBuilderError(e.to_string().into()))?;

    let post = diesel::insert_into(posts::table)
        .values(post)
        .execute(&mut *conn)
        .await?;
    Ok(post == 1)
}
