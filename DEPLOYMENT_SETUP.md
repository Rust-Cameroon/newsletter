# GitHub Actions CI/CD Deployment Setup

This document provides instructions for setting up the GitHub Actions CI/CD pipeline for deploying your Dockerized application to AWS EC2.

## Overview

The deployment pipeline includes:
- **Build & Push**: Builds Docker images and pushes them to GitHub Container Registry (GHCR)
- **Deploy**: Deploys to EC2 using Docker Compose
- **Health Check**: Verifies deployment success
- **Rollback**: Automatically rolls back on failure

## Required GitHub Secrets

You need to configure the following secrets in your GitHub repository:

### 1. Navigate to Repository Settings
1. Go to your GitHub repository
2. Click on **Settings** tab
3. In the left sidebar, click **Secrets and variables** → **Actions**

### 2. Add Required Secrets

Click **New repository secret** for each of the following:

#### `EC2_HOST`
- **Value**: Your EC2 instance's public IP address or DNS name
- **Example**: `54.123.45.67` or `ec2-54-123-45-67.compute-1.amazonaws.com`

#### `EC2_USER`
- **Value**: SSH username for your EC2 instance
- **Example**: `ubuntu` (default for Ubuntu instances)

#### `EC2_SSH_KEY`
- **Value**: The complete contents of your private SSH key
- **How to get**: 
  ```bash
  cat ~/.ssh/your-private-key.pem
  ```
- **Important**: Include the entire key including `-----BEGIN` and `-----END` lines

#### `HEALTH_CHECK_URL` (Optional)
- **Value**: URL endpoint for health checks
- **Default**: `https://rustcameroon.com/api` (if not provided)
- **Example**: `https://yourdomain.com/api`

## EC2 Instance Setup

### 1. Install Docker and Docker Compose
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker ubuntu

# Install Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Log out and back in to apply group changes
```

### 2. Create Application Directory
```bash
# Create app directory
sudo mkdir -p /home/ubuntu/app
sudo chown ubuntu:ubuntu /home/ubuntu/app
cd /home/ubuntu/app
```

### 3. Setup SSL Certificates (if using HTTPS)
```bash
# Create certificates directory
sudo mkdir -p /root/certs/rustcameroon.com-0001
# Copy your SSL certificates to this directory
```

### 4. Configure SSH Access
Ensure your EC2 instance allows SSH access from GitHub Actions IPs:
- Security Group: Allow inbound SSH (port 22) from `0.0.0.0/0` or GitHub's IP ranges
- Key Pair: Ensure the private key matches what you put in `EC2_SSH_KEY` secret

## Repository Configuration

### 1. Update Repository Name
In the workflow file `.github/workflows/deploy.yml`, update the repository name:
```yaml
env:
  IMAGE_NAME_FRONTEND: ${{ github.repository }}/frontend
  IMAGE_NAME_BACKEND: ${{ github.repository }}/backend
```

### 2. Update Rollback Script
In `scripts/rollback.sh`, update the repository name:
```bash
REPO_NAME="your-username/your-repo"  # Update this with your actual repository name
```

## Workflow Features

### Automatic Triggers
- **Push to main**: Automatically deploys on every push to the main branch
- **Manual trigger**: Can be triggered manually from GitHub Actions tab

### Image Tagging
- **latest**: Always points to the most recent deployment
- **SHA**: Tagged with 7-character git SHA for rollback purposes
- **Registry**: Images are stored in GitHub Container Registry (GHCR)

### Rollback Mechanism
- **Automatic**: Rolls back if health check fails
- **Manual**: Use the provided rollback script on EC2
- **Tracking**: Maintains `.last-successful-deploy` file with successful SHA

## Manual Rollback

If you need to manually rollback on the EC2 instance:

### 1. Copy Rollback Script
```bash
# Copy the rollback script to your EC2 instance
scp scripts/rollback.sh ubuntu@your-ec2-ip:/home/ubuntu/
```

### 2. Run Rollback
```bash
# SSH into your EC2 instance
ssh ubuntu@your-ec2-ip

# Navigate to app directory
cd /home/ubuntu/app

# Run rollback (to last successful deployment)
./rollback.sh

# Or rollback to specific SHA
./rollback.sh abc1234
```

## Monitoring and Troubleshooting

### 1. Check Workflow Status
- Go to **Actions** tab in your GitHub repository
- Click on the latest workflow run to see detailed logs

### 2. Check EC2 Status
```bash
# SSH into EC2 and check container status
ssh ubuntu@your-ec2-ip
cd /home/ubuntu/app
docker compose -f docker-compose.prod.yml ps
docker compose -f docker-compose.prod.yml logs
```

### 3. Health Check Endpoint
The workflow checks the health endpoint at:
- Default: `https://rustcameroon.com/api`
- Custom: Set via `HEALTH_CHECK_URL` secret

### 4. Common Issues

#### SSH Connection Failed
- Verify `EC2_HOST` and `EC2_USER` secrets
- Check EC2 security group allows SSH
- Ensure SSH key is correctly formatted in `EC2_SSH_KEY`

#### Health Check Failed
- Verify the health check URL is accessible
- Check if the backend service is running
- Review container logs for errors

#### Image Pull Failed
- Ensure GitHub Container Registry access is configured
- Check if images were successfully built and pushed
- Verify repository permissions

## Security Considerations

1. **SSH Key**: Store private SSH key securely in GitHub secrets
2. **Container Registry**: Images are private by default in GHCR
3. **Environment Variables**: Sensitive data should be in GitHub secrets
4. **Network**: Use security groups to restrict access to necessary ports only

## Customization

### Custom Health Check
Modify the health check logic in the workflow:
```yaml
- name: Health Check
  run: |
    # Your custom health check logic here
```

### Additional Services
Add more services to the docker-compose files as needed.

### Environment-Specific Configurations
Create separate workflow files for different environments (staging, production).

## Support

For issues or questions:
1. Check the GitHub Actions logs
2. Review EC2 container logs
3. Verify all secrets are correctly configured
4. Ensure EC2 instance has proper permissions and network access
