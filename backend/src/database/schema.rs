// @generated automatically by Diesel CLI.

diesel::table! {
    subscribers (id) {
        id -> Int4,
        email -> Varchar,
    }
}

diesel::table! {
    posts (id) {
        id -> Int4,
        title -> VarChar,
        content -> VarChar,
        image_url -> Nullable<VarChar>,
        link -> Nullable<VarChar>,
    }
}