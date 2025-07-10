# Étape 1 : Utiliser PHP 8.2 avec FPM
FROM php:8.2-fpm

# Installer les dépendances système et extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libxml2-dev \
    libpng-dev libjpeg-dev libonig-dev libpq-dev \
    libxslt1-dev libmcrypt-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath zip xml

# Installer Composer (depuis l’image officielle)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www

# Copier les fichiers de l'application
COPY . .

# Installer les dépendances Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Créer le fichier sqlite si nécessaire
RUN mkdir -p database && touch database/database.sqlite

# Donner les bonnes permissions
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Exposer le port 9000 (PHP-FPM)
EXPOSE 9000

# Lancer PHP-FPM
CMD ["php-fpm"]
