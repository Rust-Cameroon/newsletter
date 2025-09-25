# Build stage
FROM rust:1.82-alpine AS builder

# Install build dependencies
RUN apk add --no-cache musl-dev pkgconfig

WORKDIR /app

# Cache dependencies first (improves rebuild time)
COPY Cargo.toml Cargo.lock ./
RUN cargo fetch

# Copy source code and build
COPY src ./src
RUN cargo build --release

# Production stage
FROM alpine:latest

# Install runtime dependencies
RUN apk add --no-cache ca-certificates

WORKDIR /app

# Copy the binary from builder stage
COPY --from=builder /app/target/release/rust-cameroon-api /app/rust-cameroon-api

# Copy posts data
COPY posts.json /app/posts.json

# Create non-root user
RUN addgroup -g 1001 -S appgroup && \
    adduser -S appuser -u 1001 -G appgroup && \
    chown -R appuser:appgroup /app

# Switch to non-root user
USER appuser

# Expose port
EXPOSE 8000

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD wget --no-verbose --tries=1 --spider http://localhost:8000/ || exit 1

# Start the application
CMD ["./rust-cameroon-api"]
