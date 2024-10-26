# Stage 1: Building the application
FROM php:8.2-fpm-alpine as builder

WORKDIR /var/www

# Install system dependencies and PHP extensions required by Laravel
RUN apk --no-cache update && apk add --no-cache \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www

# Install Laravel dependencies with optimized autoloader
RUN composer install --no-dev --optimize-autoloader && \
    composer clear-cache

# Set correct permissions for Laravel cache and storage directories
# RUN chown -R www-data:www-data /var/www/bootstrap/cache && \
#     chmod -R 775 /var/www/bootstrap/cache && \
#     chown -R www-data:www-data /var/www/storage && \
#     chmod -R 775 /var/www/storage

# Stage 2: Creating the final image
FROM php:8.2-fpm-alpine

WORKDIR /var/www

# Install system dependencies for PHP extensions
RUN apk --no-cache update && apk add --no-cache \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions required by Laravel (including pdo_mysql)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the built application from the builder stage
COPY --from=builder /var/www /var/www

# Apply your PHP INI settings
COPY ./.setup/php/php.ini /usr/local/etc/php/conf.d/custom.ini

COPY ./.setup/php/php-fpm-www.conf /usr/local/etc/php-fpm.d/www.conf

# Set correct permissions
RUN chown -R www-data:www-data /var/www

EXPOSE 9000

CMD ["php-fpm"]
