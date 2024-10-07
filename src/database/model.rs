use diesel::{
    prelude::{Insertable, Queryable},
    Selectable,
};

#[derive(Queryable, Selectable, Insertable)]
#[diesel(table_name = crate::database::schema::subscribers)]
#[diesel(check_for_backend(diesel::pg::Pg))]
#[derive(Debug)]
pub struct Subcribers {
    pub id: i32,
    pub email: String,
}

#[derive(Insertable)]
#[diesel(table_name = crate::database::schema::subscribers)]
pub struct NewSubscriber {
    pub email: String,
}



































