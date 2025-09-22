FROM nginx:alpine

# Install envsubst
RUN apk add --no-cache gettext

# Copy built app
COPY dist /usr/share/nginx/html

# Copy configs
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Expose only 80 + 443
EXPOSE 80 443

# Always use HTTPS + generate nginx configs
CMD sh -c '\
  envsubst < /etc/nginx/templates/default-http.conf.template > /etc/nginx/conf.d/http.conf && \
  envsubst < /etc/nginx/templates/default-https.conf.template > /etc/nginx/conf.d/https.conf && \
  exec nginx -g "daemon off;"'
