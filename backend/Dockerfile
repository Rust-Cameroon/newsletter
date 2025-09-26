# Build stage
FROM rust:latest AS builder

# Install build dependencies for static linking
RUN apt-get update && apt-get install -y musl-dev pkg-config libssl-dev && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Install musl target for static linking
RUN rustup target add x86_64-unknown-linux-musl

COPY Cargo.toml Cargo.lock ./
COPY src ./src

# Build with static linking to avoid GLIBC issues
ENV RUSTFLAGS="-C target-feature=+crt-static"
RUN cargo build --release --target x86_64-unknown-linux-musl

# Production stage - use Alpine for better compatibility
FROM alpine:latest

# Install runtime dependencies
RUN apk --no-cache add ca-certificates wget

WORKDIR /app

# Copy the statically linked binary
COPY --from=builder /app/target/x86_64-unknown-linux-musl/release/rust-cameroon-api /app/rust-cameroon-api
COPY posts.json /app/posts.json

# Create non-root user
RUN addgroup -g 1001 appgroup && \
    adduser -D -u 1001 -G appgroup appuser && \
    chown -R appuser:appgroup /app

USER appuser
EXPOSE 8000

HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD wget --no-verbose --tries=1 --spider http://localhost:8000/ || exit 1

CMD ["./rust-cameroon-api"]
