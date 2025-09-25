#!/bin/bash

# Manual Rollback Script for EC2 Deployment
# Usage: ./rollback.sh [SHA]
# If no SHA is provided, it will rollback to the last successful deployment

set -e

# Configuration
APP_DIR="${EC2_APP_DIR:-/root/Newsletter}"
REGISTRY="ghcr.io"
REPO_NAME="Rust-Cameroon/Newsletter"  # Update this with your actual repository name
HEALTH_CHECK_URL="${HEALTH_CHECK_URL:-https://rustcameroon.com/api}"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}=== Manual Rollback Script ===${NC}"

# Check if we're running on EC2
if [ ! -d "$APP_DIR" ]; then
    echo -e "${RED}Error: This script should be run on the EC2 instance${NC}"
    echo "Expected app directory: $APP_DIR"
    exit 1
fi

cd "$APP_DIR"

# Determine rollback target
if [ -n "$1" ]; then
    ROLLBACK_SHA="$1"
    echo -e "${YELLOW}Rolling back to specified SHA: $ROLLBACK_SHA${NC}"
else
    if [ -f ".last-successful-deploy" ]; then
        ROLLBACK_SHA=$(cat .last-successful-deploy)
        echo -e "${YELLOW}Rolling back to last successful deployment: $ROLLBACK_SHA${NC}"
    else
        echo -e "${RED}Error: No SHA provided and no .last-successful-deploy file found${NC}"
        echo "Usage: $0 [SHA]"
        echo "Example: $0 abc1234"
        exit 1
    fi
fi

# Verify the SHA format (7 characters)
if [[ ! "$ROLLBACK_SHA" =~ ^[a-f0-9]{7}$ ]]; then
    echo -e "${RED}Error: Invalid SHA format. Expected 7-character hex string${NC}"
    exit 1
fi

echo -e "${YELLOW}Creating rollback compose file...${NC}"

# Create rollback compose file
cat > docker-compose.rollback.yml << EOF
services:
  frontend:
    image: $REGISTRY/$REPO_NAME/frontend:$ROLLBACK_SHA
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - /root/certs/rustcameroon.com-0001:/etc/letsencrypt/live/rustcameroon.com-0001:ro
    environment:
      - BACKEND_URL=http://backend:8000
      - VITE_API_URL=https://rustcameroon.com/api
      - NGINX_CONFIG=https
    user: "0:0"
    depends_on:
      - backend
      - minio
    restart: unless-stopped
    ulimits:
      nofile:
        soft: 65536
        hard: 65536

  backend:
    image: $REGISTRY/$REPO_NAME/backend:$ROLLBACK_SHA
    # SECURITY: Backend port is not exposed externally - only accessible via frontend
    volumes:
      - ./backend/posts.json:/app/posts.json:rw
    environment:
      - RUST_LOG=info
      - PORT=8000
      - DATABASE_URL=${DATABASE_URL:-postgres://user:password@localhost:5432/rustcameroon}
      - MINIO_ENDPOINT=http://minio:9000
      - MINIO_ACCESS_KEY=${MINIO_ACCESS_KEY:-minioadmin}
      - MINIO_SECRET_KEY=${MINIO_SECRET_KEY:-minioadmin123}
      - MINIO_BUCKET=${MINIO_BUCKET:-rust-cameroon-images}
    depends_on:
      - minio
    restart: unless-stopped

  minio:
    image: minio/minio:latest
    ports:
      - "9000:9000"
      - "9001:9001"
    volumes:
      - minio_data:/data
    environment:
      - MINIO_ROOT_USER=${MINIO_ACCESS_KEY:-minioadmin}
      - MINIO_ROOT_PASSWORD=${MINIO_SECRET_KEY:-minioadmin123}
    command: server /data --console-address ":9001"
    restart: unless-stopped
    healthcheck:
      test: ["CMD", "curl", "-f", "http://localhost:9000/minio/health/live"]
      interval: 30s
      timeout: 20s
      retries: 3

volumes:
  minio_data:
EOF

echo -e "${YELLOW}Stopping current containers...${NC}"
docker compose -f docker-compose.prod.yml down

echo -e "${YELLOW}Pulling rollback images...${NC}"
docker compose -f docker-compose.rollback.yml pull

echo -e "${YELLOW}Starting rollback containers...${NC}"
docker compose -f docker-compose.rollback.yml up -d --no-deps

echo -e "${YELLOW}Waiting for services to start...${NC}"
sleep 30

echo -e "${YELLOW}Performing health check...${NC}"
for i in {1..10}; do
    echo "Health check attempt $i/10..."
    if curl -f -s --max-time 10 "$HEALTH_CHECK_URL" > /dev/null; then
        echo -e "${GREEN}Health check passed!${NC}"
        break
    else
        echo "Health check failed, retrying in 10 seconds..."
        sleep 10
    fi
    
    if [ $i -eq 10 ]; then
        echo -e "${RED}Health check failed after 10 attempts.${NC}"
        echo -e "${YELLOW}You may need to investigate the issue manually.${NC}"
        exit 1
    fi
done

echo -e "${YELLOW}Replacing production compose file...${NC}"
mv docker-compose.rollback.yml docker-compose.prod.yml

echo -e "${GREEN}Rollback completed successfully!${NC}"
echo -e "${GREEN}Application is now running with SHA: $ROLLBACK_SHA${NC}"

# Show current status
echo -e "${YELLOW}Current container status:${NC}"
docker compose -f docker-compose.prod.yml ps
