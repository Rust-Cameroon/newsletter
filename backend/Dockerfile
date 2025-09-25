# Build stage
FROM rust:latest AS builder

# Install build dependencies (Debian/Ubuntu)
RUN apt-get update && apt-get install -y musl-dev pkg-config && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY Cargo.toml Cargo.lock ./
COPY src ./src
RUN cargo build --release

# Production stage
FROM debian:bookworm-slim

RUN apt-get update && apt-get install -y ca-certificates wget && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY --from=builder /app/target/release/rust-cameroon-api /app/rust-cameroon-api
COPY posts.json /app/posts.json

RUN groupadd -g 1001 appgroup && \
    useradd -u 1001 -g appgroup -M appuser && \
    chown -R appuser:appgroup /app

USER appuser
EXPOSE 8000

HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD wget --no-verbose --tries=1 --spider http://localhost:8000/ || exit 1

CMD ["./rust-cameroon-api"]
