FROM rust:latest AS builder

WORKDIR /app


COPY . .

RUN cargo build --release

FROM ubuntu 

RUN apt update && apt install -y libpq5

WORKDIR /app

COPY --from=builder /app/target/release/newsletter ./newsletter
EXPOSE 8000


CMD ["/app/newsletter"]
