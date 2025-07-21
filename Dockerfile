# Étape 1 : construire l'app
FROM php:8.2-fpm

# Installer dépendances système, PHP extensions, nginx, supervisor
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git \
    unzip \
    libonig-dev \
    libzip-dev \
    zip \
    curl \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier les fichiers de l'app
COPY . .

RUN git config --global --add safe.directory /var/www/html

# Installer les dépendances PHP via Composer
RUN composer install --optimize-autoloader --no-dev

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Copier la config nginx et supervisord
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Exposer le port 80 (Nginx)
EXPOSE 80

# Lancer supervisord qui gérera nginx + php-fpm
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
