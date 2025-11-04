FROM php:8.2-fpm

WORKDIR /var/www/

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Composer をインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
