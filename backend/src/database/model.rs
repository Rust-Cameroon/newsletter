use diesel::{
    prelude::{Insertable, Queryable},
    Selectable,
};

#[derive(Queryable, Insertable, Selectable)]
#[diesel(table_name = crate::database::schema::subscribers)]
#[diesel(check_for_backend(diesel::pg::Pg))]
pub struct Subcriber {
    pub id: i32,
    pub email: String,
}

#[derive(Insertable)]
#[diesel(table_name = crate::database::schema::subscribers)]
pub struct NewSubscriber {
    pub email: String,
}

use serde::{Deserialize, Serialize};

#[derive(Debug, Serialize, Deserialize, Queryable, Insertable, Selectable)]
#[diesel(table_name = crate::database::schema::posts)]
#[diesel(check_for_backend(diesel::pg::Pg))]
pub struct Post {
    id: i32,
    title: String,
    content: String,
    image_url: Option<String>,
    link: Option<String>,
}

#[derive(Insertable)]
#[derive(Deserialize)]
#[diesel(table_name = crate::database::schema::posts)]
pub struct NewPost {
    pub title: String,
    pub content: String,
    pub image_url: Option<String>,
    pub link: Option<String>,
}
