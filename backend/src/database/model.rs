use diesel::{prelude::{Insertable, Queryable}, Selectable};

#[derive(Queryable, Insertable, Selectable)]
#[diesel(table_name = crate::database::schema::subscribers)]
#[diesel(check_for_backend(diesel::pg::Pg))]
pub struct Subcriber{
    pub id: i32,
    pub email: String,
}

#[derive(Insertable)]
#[diesel(table_name = crate::database::schema::subscribers)]
pub struct NewSubscriber {
    pub email: String,
}

