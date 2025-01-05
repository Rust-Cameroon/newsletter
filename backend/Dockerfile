FROM rust:latest AS builder

# Install Diesel CLI during the build stage
RUN apt-get update && apt-get install -y libpq-dev && \
    cargo install diesel_cli --no-default-features --features postgres

WORKDIR /app

COPY . .

RUN cargo build --release

FROM ubuntu 

# Install the required PostgreSQL client libraries for Diesel
RUN apt update && apt install -y libpq5

WORKDIR /app

# Copy the application binary and Diesel CLI binary
COPY --from=builder /app/target/release/newsletter ./newsletter
COPY --from=builder /usr/local/cargo/bin/diesel /usr/local/bin/diesel

# Copy the migrations directory
COPY ./src/database/2024-12-31-221109_migrations ./migrations

COPY .env .env

EXPOSE 8000

CMD ["/app/newsletter"]
