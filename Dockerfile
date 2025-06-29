FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    wget git unzip zip libzip-dev curl libpq-dev build-essential \
    && docker-php-ext-install pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
