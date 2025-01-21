# Utiliser une image PHP avec PHP-FPM
FROM php:8.2-fpm

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    zip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql zip

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers du projet Symfony
COPY . .

# Vérifier que le fichier composer.json est bien copié
RUN ls -la /var/www/html

# Installer les dépendances Symfony
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install

# Donner les permissions nécessaires
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exposer le port utilisé par Symfony (8000 par défaut)
EXPOSE 8000

# Commande par défaut pour démarrer Symfony
CMD ["symfony", "serve", "--no-tls", "--port=8000", "--allow-all-hosts"]