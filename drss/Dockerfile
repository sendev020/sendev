# Étape 1 : Image PHP avec extensions nécessaires
FROM php:8.2-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath zip

# Installer Composer (depuis image officielle)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www

# Copier tous les fichiers du projet dans le conteneur
COPY . .

# Installer les dépendances PHP de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Donner les bonnes permissions à Laravel
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Exposer le port 9000 pour PHP-FPM (optionnel si usage avec Nginx séparé)
EXPOSE 9000

# Commande de lancement
CMD ["php-fpm"]
