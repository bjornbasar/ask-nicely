# Use the official lightweight Node image
FROM node:14 AS build-stage

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json to the working directory
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application files
COPY . .
RUN rm -rf backend

# Build the Vue.js app
RUN npm run build

# Production stage
FROM nginx:1.21.3-alpine AS production-stage

# Copy the built app to the nginx public directory
COPY --from=build-stage /app/dist /usr/share/nginx/html

# Expose port 80
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]