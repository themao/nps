# PHP 8.2.35 contains the fix for CVE-2026-109618 / CVE-2026-109619 ("PHP2Shell").
FROM php:8.2.35-fpm-alpine3.24@sha256:a7e345653610c099afe283e8b724cc8a997646be77a5caca54822a8cd1d04c98 AS base

WORKDIR /var/www

ENV IMAGICK_VERSION=3.7.0

RUN set -eux \
    && apk add --no-cache \
        icu-libs \
        imagemagick \
        libgomp \
        libjpeg-turbo \
        libpng \
        libwebp \
        libzip \
    && apk add --no-cache --virtual .build-deps \
        ${PHPIZE_DEPS} \
        icu-dev \
        imagemagick-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        libzip-dev \
        linux-headers \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        gd \
        intl \
        opcache \
        pdo_mysql \
        zip \
    && pecl install imagick-${IMAGICK_VERSION} \
    && docker-php-ext-enable imagick \
    && apk del .build-deps \
    && rm -rf /tmp/pear

COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer
COPY docker/php/nps.ini $PHP_INI_DIR/conf.d/zz-nps.ini
COPY docker/php/zz-pool.conf /usr/local/etc/php-fpm.d/zz-pool.conf

RUN apk add --no-cache shadow && usermod -u 1000 www-data && apk del shadow


FROM base AS dev

RUN set -eux \
    && mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini \
    && apk add --no-cache --virtual .build-deps ${PHPIZE_DEPS} linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del .build-deps \
    && rm -rf /tmp/pear \
    && { \
        echo "xdebug.mode=debug"; \
        echo "xdebug.start_with_request=yes"; \
        echo "xdebug.idekey=XDEBUG_PHPSTORM"; \
        echo "xdebug.client_host=host.docker.internal"; \
    } >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

ENV APP_ENV=dev


FROM base AS prod

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini \
    && echo "opcache.validate_timestamps=0" >> $PHP_INI_DIR/conf.d/zz-nps.ini

ENV APP_ENV=prod

COPY composer.json composer.lock symfony.lock* ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-progress

COPY --chown=www-data:www-data . .
RUN set -eux \
    && composer dump-autoload --no-dev --classmap-authoritative \
    && composer run-script --no-dev auto-scripts \
    && mkdir -p var web/uploads/media \
    && chown -R www-data:www-data var web/uploads
