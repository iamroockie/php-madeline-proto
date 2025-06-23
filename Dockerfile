FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip wget zip libzip-dev libpq-dev curl build-essential \
    && docker-php-ext-install pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
