FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libxml2-dev \
    libpng-dev libjpeg-dev libonig-dev libpq-dev \
    libxslt1-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath zip xml \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .
RUN composer config -g github-oauth.github.com <your_token_if_needed>

RUN composer install --no-interaction --prefer-dist --optimize-autoloader || (cat /root/.composer/composer.log && false)
RUN php artisan key:generate || (cat storage/logs/laravel.log && false)


EXPOSE 80

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
