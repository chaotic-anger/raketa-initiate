FROM php:8.2-fpm

ARG HOST_UID
ARG HOST_GID

RUN apt-get update && apt-get install -y git unzip libzip-dev \
    && docker-php-ext-install zip

RUN pecl install redis && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g ${HOST_GID} appgroup \
    && useradd -u ${HOST_UID} -g appgroup -m appuser

WORKDIR /app
USER appuser