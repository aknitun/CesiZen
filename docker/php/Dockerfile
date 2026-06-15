FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev libicu-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql intl opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --prefer-dist

COPY . .

RUN composer dump-autoload --optimize \
    && composer run-script post-install-cmd --no-interaction || true

RUN chown -R www-data:www-data var/