# Deployment Guide - Rust Cameroon Website

This guide provides step-by-step instructions for deploying the Rust Cameroon website to AWS EC2 with SSL support.

## Prerequisites

- AWS EC2 instance (Ubuntu 22.04 LTS recommended)
- Domain name pointing to your EC2 instance
- SSH access to your EC2 instance
- Local development environment set up

## Quick Deployment

### 1. Configure Your Domain

Update the deployment script with your domain and EC2 details:

```bash
# Edit scripts/deploy.sh
nano scripts/deploy.sh

# Update these variables:
DOMAIN="your-domain.com"
EC2_USER="ubuntu"
EC2_HOST="your-ec2-ip-address"
```

### 2. Deploy the Application

```bash
# Make scripts executable
chmod +x scripts/*.sh

# Deploy to EC2
./scripts/deploy.sh
```

### 3. Setup SSL Certificate

```bash
# SSH into your server
ssh ubuntu@your-ec2-ip

# Run SSL setup
sudo ./scripts/ssl-setup.sh your-domain.com
```

### 4. Access Your Website

- Website: https://your-domain.com
- Admin Panel: https://your-domain.com/admin
- Default admin password: `admin123` (change immediately!)

## Manual Deployment Steps

If you prefer to deploy manually or need to troubleshoot:

### 1. Server Setup

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install -y nginx certbot python3-certbot-nginx ufw fail2ban

# Configure firewall
sudo ufw enable
sudo ufw allow ssh
sudo ufw allow 'Nginx Full'
```

### 2. Build and Deploy Application

```bash
# Build frontend
cd frontend
npm install
npm run build

# Build backend
cd ../backend
cargo build --release

# Copy files to server
scp -r frontend/dist/* ubuntu@your-ec2-ip:/tmp/frontend/
scp backend/target/release/rust-cameroon-api ubuntu@your-ec2-ip:/tmp/backend/
scp backend/posts.json ubuntu@your-ec2-ip:/tmp/backend/
```

### 3. Server Configuration

```bash
# SSH into server
ssh ubuntu@your-ec2-ip

# Create application directory
sudo mkdir -p /var/www/rust-cameroon
sudo mkdir -p /var/www/rust-cameroon/api

# Copy application files
sudo cp -r /tmp/frontend/* /var/www/rust-cameroon/
sudo cp /tmp/backend/rust-cameroon-api /var/www/rust-cameroon/api/
sudo cp /tmp/backend/posts.json /var/www/rust-cameroon/api/

# Set permissions
sudo chown -R www-data:www-data /var/www/rust-cameroon
sudo chmod +x /var/www/rust-cameroon/api/rust-cameroon-api
```

### 4. Configure Nginx

```bash
# Copy Nginx configuration
sudo cp nginx-https.conf /etc/nginx/sites-available/rust-cameroon

# Update domain in configuration
sudo sed -i 's/your-domain.com/your-actual-domain.com/g' /etc/nginx/sites-available/rust-cameroon

# Enable site
sudo ln -s /etc/nginx/sites-available/rust-cameroon /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default

# Test configuration
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx
```

### 5. Create Systemd Service

```bash
# Create service file
sudo tee /etc/systemd/system/rust-cameroon-api.service > /dev/null <<EOF
[Unit]
Description=Rust Cameroon API
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=/var/www/rust-cameroon/api
ExecStart=/var/www/rust-cameroon/api/rust-cameroon-api
Restart=always
RestartSec=5
Environment=RUST_LOG=info
Environment=PORT=8000

[Install]
WantedBy=multi-user.target
EOF

# Enable and start service
sudo systemctl daemon-reload
sudo systemctl enable rust-cameroon-api
sudo systemctl start rust-cameroon-api
```

### 6. Setup SSL Certificate

```bash
# Obtain SSL certificate
sudo certbot --nginx -d your-domain.com -d www.your-domain.com --email admin@your-domain.com --agree-tos --non-interactive --redirect

# Test certificate renewal
sudo certbot renew --dry-run

# Setup automatic renewal
echo "0 */12 * * * root certbot renew --quiet --post-hook 'systemctl reload nginx'" | sudo tee /etc/cron.d/certbot-renew
```

## Docker Deployment

For containerized deployment:

### 1. Build and Run with Docker Compose

```bash
# Build and start services
docker-compose -f docker-compose.prod.yml up -d

# Check status
docker-compose -f docker-compose.prod.yml ps
```

### 2. Setup SSL with Docker

```bash
# Install certbot on host
sudo apt install certbot

# Obtain certificate
sudo certbot certonly --webroot -w ./frontend/dist -d your-domain.com

# Update docker-compose to mount certificates
# Edit docker-compose.prod.yml to include certificate volumes
```

## Environment Configuration

### Frontend Environment Variables

Create `frontend/.env`:

```env
VITE_API_URL=https://your-domain.com/api
VITE_ADMIN_PASSWORD=your-secure-password
```

### Backend Environment Variables

The backend uses these environment variables:

```bash
RUST_LOG=info
PORT=8000
```

## Security Considerations

### 1. Change Default Admin Password

```bash
# Update frontend/.env
VITE_ADMIN_PASSWORD=your-very-secure-password
```

### 2. Configure Firewall

```bash
# Allow only necessary ports
sudo ufw allow ssh
sudo ufw allow 'Nginx Full'
sudo ufw deny 8000  # Block direct access to backend
```

### 3. Setup Fail2ban

```bash
# Configure fail2ban
sudo tee /etc/fail2ban/jail.local > /dev/null <<EOF
[DEFAULT]
bantime = 3600
findtime = 600
maxretry = 3

[nginx-http-auth]
enabled = true

[nginx-limit-req]
enabled = true
EOF

sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

## Monitoring and Maintenance

### 1. Check Service Status

```bash
# Check all services
sudo systemctl status rust-cameroon-api nginx fail2ban

# Check logs
sudo journalctl -u rust-cameroon-api -f
sudo journalctl -u nginx -f
```

### 2. Update Application

```bash
# Pull latest changes
git pull origin main

# Rebuild and redeploy
npm run build
./scripts/deploy.sh
```

### 3. Backup Data

```bash
# Backup posts data
sudo cp /var/www/rust-cameroon/api/posts.json /backup/posts-$(date +%Y%m%d).json

# Backup SSL certificates
sudo cp -r /etc/letsencrypt /backup/letsencrypt-$(date +%Y%m%d)
```

## Troubleshooting

### Common Issues

1. **502 Bad Gateway**
   - Check if backend service is running: `sudo systemctl status rust-cameroon-api`
   - Check backend logs: `sudo journalctl -u rust-cameroon-api -f`

2. **SSL Certificate Issues**
   - Verify domain DNS: `nslookup your-domain.com`
   - Check certificate status: `sudo certbot certificates`

3. **Permission Issues**
   - Fix file permissions: `sudo chown -R www-data:www-data /var/www/rust-cameroon`

4. **Nginx Configuration Errors**
   - Test configuration: `sudo nginx -t`
   - Check error logs: `sudo tail -f /var/log/nginx/error.log`

### Log Locations

- Nginx access logs: `/var/log/nginx/rust-cameroon.access.log`
- Nginx error logs: `/var/log/nginx/rust-cameroon.error.log`
- Backend logs: `sudo journalctl -u rust-cameroon-api`
- System logs: `/var/log/syslog`

## Performance Optimization

### 1. Enable Gzip Compression

Already configured in `nginx.conf`:

```nginx
gzip on;
gzip_vary on;
gzip_min_length 1024;
gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
```

### 2. Configure Caching

Static assets are cached for 1 year:

```nginx
location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
    expires 1y;
    add_header Cache-Control "public, immutable";
}
```

### 3. Monitor Performance

```bash
# Check server resources
htop
df -h
free -h

# Monitor Nginx performance
sudo tail -f /var/log/nginx/rust-cameroon.access.log
```

## Support

If you encounter issues:

1. Check the logs first
2. Verify all services are running
3. Test configuration files
4. Check firewall and DNS settings
5. Create an issue on GitHub with logs and error details

For additional help, contact the Rust Cameroon community on Discord or GitHub.
