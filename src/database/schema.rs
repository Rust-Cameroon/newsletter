// @generated automatically by Diesel CLI.

diesel::table! {
    subscribers (id) {
        id -> Int4,
        email -> Nullable<Varchar>,
    }
}
