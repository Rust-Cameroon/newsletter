#!/bin/bash

# Comprehensive deployment script with SSL setup
# This script handles both SSL certificate setup and Docker deployment

set -e

if [ -z "$1" ]; then
    echo "❌ Error: Domain name is required"
    echo "Usage: $0 <domain-name>"
    echo "Example: $0 rustcameroon.com"
    exit 1
fi

DOMAIN="$1"
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(dirname "$SCRIPT_DIR")"

echo "🚀 Starting deployment for $DOMAIN..."

# Step 1: Setup SSL certificates
echo "🔒 Setting up SSL certificates..."
cd "$PROJECT_DIR"
./scripts/ssl-setup.sh "$DOMAIN"

# Step 2: Check if SSL certificates are available
if [ -f "/etc/letsencrypt/live/$DOMAIN/fullchain.pem" ] && [ -f "/etc/letsencrypt/live/$DOMAIN/privkey.pem" ]; then
    echo "✅ SSL certificates found, switching to HTTPS configuration..."
    ./scripts/switch-nginx-config.sh https
else
    echo "⚠️  SSL certificates not found, using HTTP-only configuration..."
    ./scripts/switch-nginx-config.sh http
fi

# Step 3: Build and deploy with Docker
echo "🐳 Building and deploying with Docker..."
docker-compose -f docker-compose.prod.yml down
docker-compose -f docker-compose.prod.yml build --no-cache
docker-compose -f docker-compose.prod.yml up -d

# Step 4: Wait for services to start
echo "⏳ Waiting for services to start..."
sleep 10

# Step 5: Check service status
echo "🔍 Checking service status..."
docker-compose -f docker-compose.prod.yml ps

# Step 6: Test the deployment
echo "🧪 Testing deployment..."
if curl -f -s http://localhost > /dev/null; then
    echo "✅ HTTP service is responding"
else
    echo "❌ HTTP service is not responding"
fi

if [ -f "/etc/letsencrypt/live/$DOMAIN/fullchain.pem" ]; then
    if curl -f -s -k https://localhost > /dev/null; then
        echo "✅ HTTPS service is responding"
    else
        echo "❌ HTTPS service is not responding"
    fi
fi

echo ""
echo "🎉 Deployment completed!"
echo "🌍 Your website should be available at:"
if [ -f "/etc/letsencrypt/live/$DOMAIN/fullchain.pem" ]; then
    echo "   https://$DOMAIN"
else
    echo "   http://$DOMAIN"
fi
echo ""
echo "📝 To view logs: docker-compose -f docker-compose.prod.yml logs -f"
echo "🔄 To restart: docker-compose -f docker-compose.prod.yml restart"
