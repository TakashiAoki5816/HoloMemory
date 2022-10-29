FROM php:8.0-fpm-alpine

# COPY php.ini
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini

# Composer install
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

# install Node.js
COPY --from=node:16.13 /usr/local/bin /usr/local/bin
COPY --from=node:16.13 /usr/local/lib /usr/local/lib

RUN apk update && \
    apk add \
    git \
    zip \
    unzip \
    vim \
    autoconf gcc g++ make && \
    docker-php-ext-install pdo_mysql bcmath && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug

WORKDIR /var/www/html
