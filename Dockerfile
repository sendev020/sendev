FROM php:8.2-fpm

# Installer les dépendances nécessaires à GD + Laravel
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libpq-dev \
    libxslt1-dev libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath zip xml gd \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer depuis l'image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Répertoire de travail
WORKDIR /var/www

# Copier tous les fichiers Laravel
COPY . .

RUN cp .env.example .env
# Installer les dépendances Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Générer la clé de l'application


RUN php artisan key:generate

# Créer les dossiers nécessaires
RUN mkdir -p storage/logs database \
    && touch database/database.sqlite \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Exposer le port
EXPOSE 8080

# Commande de démarrage
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
