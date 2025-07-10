FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN php artisan key:generate
RUN mkdir -p storage/logs database
RUN touch database/database.sqlite
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 storage bootstrap/cache

# Permissions
RUN chown -R www-data:www-data /var/www

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
EXPOSE 8080
