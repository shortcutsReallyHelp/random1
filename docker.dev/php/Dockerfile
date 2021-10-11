FROM composer:2.0.11 AS composer

FROM php:7.4.15-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev git libzip-dev zip libpq-dev  libxml2-dev libfreetype6-dev  libjpeg62-turbo-dev libmcrypt-dev  libpng-dev libicu-dev
RUN docker-php-ext-configure zip && docker-php-ext-install pgsql pdo_pgsql zip soap gd intl

COPY --from=composer /usr/bin/composer /usr/bin/composer
