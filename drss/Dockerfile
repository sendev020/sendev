FROM php:8.2-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libxml2-dev \
    libpng-dev libjpeg-dev libonig-dev libpq-dev \
    libxslt1-dev libicu-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath zip xml gd \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier tous les fichiers du projet
COPY . .

# Installer les dépendances PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Générer la clé Laravel
RUN php artisan key:generate

# Préparer les répertoires nécessaires
RUN mkdir -p storage/logs database \
    && touch database/database.sqlite \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8080

# Lancer Laravel via le serveur intégré
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
