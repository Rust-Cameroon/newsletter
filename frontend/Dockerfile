FROM nginx:alpine

# Install envsubst
RUN apk add --no-cache gettext

# Copy built React app
COPY dist /usr/share/nginx/html

# Copy Nginx template (with ${BACKEND_URL})
COPY nginx.conf.template /etc/nginx/nginx.conf.template

# Expose HTTP + HTTPS
EXPOSE 80 443

# Substitute environment variables and start Nginx
CMD envsubst '$BACKEND_URL' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf \
    && nginx -g 'daemon off;'
