# Use the official PHP image
FROM php:latest

# Set the working directory
WORKDIR /var/www/html

# Copy only necessary files and folders (excluding backend)
COPY . .

# Install necessary PHP extensions and dependencies
RUN docker-php-ext-install pdo pdo_mysql

# Expose port 80
EXPOSE 80

# CMD to start PHP built-in server on container start
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]