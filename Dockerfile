# Use the official PHP image with Apache
FROM php:7.4-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    && docker-php-ext-install zip mysqli

# Enable Apache mod_rewrite for potential URL rewriting
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html/todo-app

# Copy composer from composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy composer files first for caching
COPY composer.json composer.lock ./

# Install PHP dependencies inside the container
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the application files
COPY . .

# Set proper file permissions (optional but good practice)
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80
EXPOSE 80
