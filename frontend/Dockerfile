FROM nginx:alpine

# Install envsubst
RUN apk add --no-cache gettext

# Copy built app
COPY dist /usr/share/nginx/html

# Copy configs
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Expose only 80 + 443
EXPOSE 80 443

