FROM php:7.4-fpm


WORKDIR /var/www/

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql zip


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
