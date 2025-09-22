#!/bin/bash

# Script to switch between HTTP-only and HTTPS nginx configurations for Docker

set -e

if [ -z "$1" ]; then
    echo "❌ Error: Configuration type is required"
    echo "Usage: $0 <http|https>"
    echo "  http  - Use HTTP-only configuration (for development or when SSL certs are not available)"
    echo "  https - Use HTTPS configuration (for production with SSL certificates)"
    exit 1
fi

CONFIG_TYPE="$1"
DOCKER_COMPOSE_FILE="docker-compose.prod.yml"

case $CONFIG_TYPE in
    "http")
        echo "🔄 Switching to HTTP-only configuration..."
        sed -i 's|NGINX_CONFIG=https|NGINX_CONFIG=http|g' $DOCKER_COMPOSE_FILE
        echo "✅ Switched to HTTP-only configuration"
        echo "📝 Note: This configuration will work without SSL certificates"
        ;;
    "https")
        echo "🔄 Switching to HTTPS configuration..."
        sed -i 's|NGINX_CONFIG=http|NGINX_CONFIG=https|g' $DOCKER_COMPOSE_FILE
        echo "✅ Switched to HTTPS configuration"
        echo "📝 Note: SSL certificates must be available at /etc/letsencrypt/live/rustcameroon.com/"
        ;;
    *)
        echo "❌ Error: Invalid configuration type '$CONFIG_TYPE'"
        echo "Valid options: http, https"
        exit 1
        ;;
esac

echo ""
echo "🔄 To apply the changes, run:"
echo "   docker-compose -f docker-compose.prod.yml down"
echo "   docker-compose -f docker-compose.prod.yml up -d"
