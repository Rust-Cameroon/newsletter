#!/bin/bash

# SSL Certificate Setup Script for Rust Cameroon Website
# This script sets up SSL certificates using Let's Encrypt

set -e

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
sed -i "s/your-domain.com/$DOMAIN/g" $NGINX_CONFIG

# Test Nginx configuration
echo "🧪 Testing Nginx configuration..."
nginx -t

# Reload Nginx
echo "🔄 Reloading Nginx..."
systemctl reload nginx

# Obtain SSL certificate
echo "📜 Obtaining SSL certificate from Let's Encrypt..."
certbot --nginx -d $DOMAIN -d www.$DOMAIN --email $EMAIL --agree-tos --non-interactive --redirect

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
