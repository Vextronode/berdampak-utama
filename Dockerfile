# syntax=docker/dockerfile:1

# ==============================================================================
# Stage 1: Build Frontend Assets (Tailwind CSS v4 + Vite JS Bundles)
# ==============================================================================
FROM node:22-alpine AS frontend-builder

WORKDIR /app

COPY package.json package-lock.json vite.config.js ./
RUN npm ci

COPY resources/ ./resources/
RUN npm run build

# ==============================================================================
# Stage 2: Install PHP Production Dependencies via Composer
# ==============================================================================
FROM composer:2 AS vendor-builder

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

# ==============================================================================
# Stage 3: Production Runtime Image (PHP 8.4 + Apache)
# ==============================================================================
FROM php:8.4-apache-bookworm AS app

WORKDIR /var/www/html

# Install system dependencies dan ekstensi PHP yang dibutuhkan Laravel 13
RUN apt-get update && apt-get install -y --no-install-recommends \
        curl \
        unzip \
        libpng-dev \
        libjpeg62-turbo-dev \
        libwebp-dev \
        libfreetype6-dev \
        libzip-dev \
        libicu-dev \
        libpq-dev \
        libsqlite3-dev \
        libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        pdo_sqlite \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        zip \
        opcache \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Konfigurasi Apache DocumentRoot ke /var/www/html/public dan tuning PHP
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/99-berdampak.ini

# Salin aplikasi, dependencies Composer, dan hasil build Vite
COPY . .
COPY --from=vendor-builder /app/vendor ./vendor
COPY --from=frontend-builder /app/public/build ./public/build

# Selesaikan package discovery Laravel setelah vendor dan kode lengkap tersedia
RUN rm -f bootstrap/cache/*.php \
    && mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && php artisan package:discover --ansi \
    && chown -R www-data:www-data storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --start-period=45s --retries=3 \
    CMD curl -fsS http://127.0.0.1/up || exit 1

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
