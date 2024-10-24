# Use the official Rust image to build the frontend
FROM rust:1.72 AS builder

# Set the working directory
WORKDIR /backend

# Copy the source code
COPY . .

# Build the frontend (replace `your_frontend_binary` with your Rust app name)
RUN cargo build --release

# Use a lightweight image to serve the built frontend

# Expose the port
EXPOSE 8000

# Start Nginx
CMD ["cargo", "run"]
