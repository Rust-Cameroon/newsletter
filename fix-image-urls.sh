#!/bin/bash

# Script to fix image URLs in posts.json from :9001 to /minio/

POSTS_FILE="backend/posts.json"

if [ ! -f "$POSTS_FILE" ]; then
    echo "Posts file not found: $POSTS_FILE"
    exit 1
fi

echo "Checking for posts with old image URLs..."

# Check if there are any URLs with :9001
if grep -q "rustcameroon.com:9001" "$POSTS_FILE"; then
    echo "Found posts with old URLs. Creating backup..."
    cp "$POSTS_FILE" "${POSTS_FILE}.backup"
    
    echo "Fixing image URLs..."
    sed -i 's|https://rustcameroon.com:9001/|https://rustcameroon.com/minio/|g' "$POSTS_FILE"
    
    echo "URLs fixed successfully!"
    echo "Backup saved as: ${POSTS_FILE}.backup"
else
    echo "No posts with old URLs found."
fi

# Also check events.json if it exists
EVENTS_FILE="backend/events.json"
if [ -f "$EVENTS_FILE" ]; then
    echo "Checking events file..."
    if grep -q "rustcameroon.com:9001" "$EVENTS_FILE"; then
        echo "Found events with old URLs. Creating backup..."
        cp "$EVENTS_FILE" "${EVENTS_FILE}.backup"
        
        echo "Fixing event URLs..."
        sed -i 's|https://rustcameroon.com:9001/|https://rustcameroon.com/minio/|g' "$EVENTS_FILE"
        
        echo "Event URLs fixed successfully!"
    else
        echo "No events with old URLs found."
    fi
fi

echo "URL fix script completed."
