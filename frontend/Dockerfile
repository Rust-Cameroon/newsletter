# Use Node.js for building the app
FROM node:alpine as build

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json
COPY package.json package-lock.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application source code
COPY . .

# Build the application
RUN npm run build

# Use Nginx to serve the app
FROM nginx:alpine

# Copy built React app
COPY --from=build /app/dist /usr/share/nginx/html

# Copy Nginx template (with ${BACKEND_URL})
COPY nginx.conf.template /etc/nginx/nginx.conf.template

# Expose HTTP + HTTPS
EXPOSE 80 443

# Substitute environment variables and start Nginx
CMD envsubst '$BACKEND_URL' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf \
    && nginx -g 'daemon off;'
