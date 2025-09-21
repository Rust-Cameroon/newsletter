#!/bin/bash

# SSL Certificate Setup Script for Rust Cameroon Website
# This script sets up SSL certificates using Let's Encrypt

set -e

# Function to setup SSL using standalone mode
setup_ssl_standalone() {
    local domain="$1"
    local email="$2"
    
    echo "🔄 Setting up SSL using standalone mode..."
    echo "⚠️  This will temporarily stop nginx to bind to port 80"
    
    # Stop nginx temporarily
    systemctl stop nginx
    
    # Obtain certificate using standalone mode
    certbot certonly --standalone -d $domain -d www.$domain --email $email --agree-tos --non-interactive
    
    # Start nginx again
    systemctl start nginx
    
    # Update nginx config to use the certificate
    echo "🔧 Updating nginx configuration to use SSL certificate..."
    
    # Add SSL configuration to nginx
    cat >> $NGINX_CONFIG << EOF

# SSL Configuration
server {
    listen 443 ssl http2;
    server_name $domain www.$domain;
    
    ssl_certificate /etc/letsencrypt/live/$domain/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/$domain/privkey.pem;
    
    # SSL Security Settings
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;
    
    # HSTS
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    
    location / {
        proxy_pass http://localhost:3000;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
    }
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name $domain www.$domain;
    return 301 https://\$server_name\$request_uri;
}
EOF
    
    # Test and reload nginx
    nginx -t
    systemctl reload nginx
}

if [ -z "$1" ]; then
    echo "❌ Error: Domain name is required"
    echo "Usage: $0 <domain-name>"
    echo "Example: $0 your-domain.com"
    exit 1
fi

DOMAIN="$1"
EMAIL="contact@$DOMAIN"
NGINX_CONFIG="/etc/nginx/sites-available/rust-cameroon"

echo "🔒 Setting up SSL certificate for $DOMAIN..."

# Update Nginx configuration with domain
echo "🌐 Updating Nginx configuration..."
sed -i "s/rustcameroon.com/$DOMAIN/g" $NGINX_CONFIG

# Test Nginx configuration
echo "🧪 Testing Nginx configuration..."
nginx -t

# Reload Nginx
echo "🔄 Reloading Nginx..."
systemctl reload nginx

# Check if certbot nginx plugin is available
echo "🔍 Checking certbot nginx plugin..."
if ! certbot plugins | grep -q nginx; then
    echo "⚠️  certbot nginx plugin is not installed"
    echo ""
    echo "📦 To install the nginx plugin, run:"
    echo "   sudo apt update"
    echo "   sudo apt install -y python3-certbot-nginx"
    echo ""
    echo "🔄 Using standalone mode instead (will temporarily stop nginx)..."
    setup_ssl_standalone "$DOMAIN" "$EMAIL"
else
    # Obtain SSL certificate using nginx plugin
    echo "📜 Obtaining SSL certificate from Let's Encrypt..."
    certbot --nginx -d $DOMAIN -d www.$DOMAIN --email $EMAIL --agree-tos --non-interactive --redirect
fi

# Test certificate renewal
echo "🔄 Testing certificate renewal..."
certbot renew --dry-run

# Setup automatic renewal
echo "⏰ Setting up automatic certificate renewal..."
cat > /etc/cron.d/certbot-renew << EOF
# Renew Let's Encrypt certificates twice daily
0 */12 * * * root certbot renew --quiet --post-hook "systemctl reload nginx"
EOF

# Create renewal script
cat > /usr/local/bin/renew-ssl.sh << 'EOF'
#!/bin/bash
# SSL Certificate Renewal Script

echo "🔄 Checking SSL certificate renewal..."
certbot renew --quiet --post-hook "systemctl reload nginx"

if [ $? -eq 0 ]; then
    echo "✅ SSL certificate renewal completed successfully"
else
    echo "❌ SSL certificate renewal failed"
    # You can add notification logic here (email, Slack, etc.)
fi
EOF

chmod +x /usr/local/bin/renew-ssl.sh

# Test the renewal script
echo "🧪 Testing renewal script..."
/usr/local/bin/renew-ssl.sh

echo "✅ SSL setup completed successfully!"
echo ""
echo "🌍 Your website is now available at: https://$DOMAIN"
echo "🔒 SSL certificate will auto-renew every 12 hours"
echo ""
echo "📝 Certificate details:"
certbot certificates
