FROM ubuntu:latest
FROM php:7.3-fpm

LABEL authors="lordmobile"

RUN apt-get update && apt-get install -y \
    git unzip zip \
    libicu-dev libzip-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
  && rm -rf /var/lib/apt/lists/*

# Extensions PHP (Symfony)
RUN docker-php-ext-install -j$(nproc) intl pdo pdo_mysql zip opcache

# GD (PHP 7.3 -> flags différents)
RUN docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install -j$(nproc) gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN npm install && npm run build

WORKDIR /var/www/html
