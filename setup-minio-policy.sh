#!/bin/bash

# Script to set up MinIO bucket policy for public read access
# This script can be run manually if the automatic policy setting fails

BUCKET_NAME="rust-cameroon-images"
MINIO_ENDPOINT="http://localhost:9000"
MINIO_ACCESS_KEY="minioadmin"
MINIO_SECRET_KEY="minioadmin123"

# Create the bucket policy JSON
POLICY_JSON=$(cat <<EOF
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Principal": "*",
            "Action": "s3:GetObject",
            "Resource": "arn:aws:s3:::${BUCKET_NAME}/*"
        }
    ]
}
EOF
)

echo "Setting up MinIO bucket policy for public read access..."
echo "Bucket: ${BUCKET_NAME}"
echo "Endpoint: ${MINIO_ENDPOINT}"

# Use mc (MinIO Client) to set the policy
# First, configure the alias
mc alias set local ${MINIO_ENDPOINT} ${MINIO_ACCESS_KEY} ${MINIO_SECRET_KEY}

# Create the bucket if it doesn't exist
mc mb local/${BUCKET_NAME} --ignore-existing

# Set the bucket policy
echo "${POLICY_JSON}" | mc policy set-json /dev/stdin local/${BUCKET_NAME}

echo "Bucket policy set successfully!"
echo "Images should now be accessible at: https://rustcameroon.com/minio/${BUCKET_NAME}/..."
