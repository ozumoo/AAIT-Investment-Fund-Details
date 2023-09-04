# Use the official PHP image as the base image
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y libpq-dev git zip unzip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www/html

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
