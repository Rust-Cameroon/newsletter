#!/bin/bash

# Script to set up local images for the first 5 posts
# This script downloads images from MinIO and saves them locally for faster loading

echo "Setting up local images for first 5 posts..."

# Create static/images directory if it doesn't exist
mkdir -p static/images

# Check if posts.json exists
if [ ! -f "data/posts.json" ]; then
    echo "Error: data/posts.json not found"
    exit 1
fi

# Get the first 5 posts (most recent) and download their images
echo "Fetching first 5 posts and downloading images..."

# Use jq to extract the first 5 posts and their image URLs
jq -r 'to_entries | sort_by(.value.date) | reverse | .[0:5] | .[] | select(.value.image_url != null) | "\(.value.id) \(.value.image_url)"' data/posts.json | while read -r post_id image_url; do
    if [ -n "$post_id" ] && [ -n "$image_url" ]; then
        echo "Downloading image for post $post_id from $image_url"
        
        # Download the image and save it locally
        if curl -s -o "static/images/${post_id}.jpg" "$image_url"; then
            echo "✓ Downloaded image for post $post_id"
        else
            echo "✗ Failed to download image for post $post_id"
        fi
    fi
done

echo "Local image setup complete!"
echo "Images are now stored in static/images/ for the first 5 posts"
echo "These will be served directly by nginx for faster loading"
