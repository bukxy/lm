# ===== FRONT =====
FROM node:16-alpine AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build


# ===== BACK =====
FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip zip \
    libicu-dev libzip-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) intl pdo pdo_mysql zip opcache

RUN docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install -j$(nproc) gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 1) Composer deps (cacheable)
COPY composer.json composer.lock* ./
RUN composer install --optimize-autoloader --no-interaction --no-scripts

# 2) Code
COPY . .

# 3)
COPY --from=node_builder /app/public/build /var/www/html/public/build

# 4) Maintenant bin/console existe, on peut warmup
RUN php bin/console cache:clear --env=prod --no-debug || true \
 && php bin/console cache:warmup --env=prod --no-debug || true
