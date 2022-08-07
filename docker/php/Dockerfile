FROM php:7.0-fpm AS builder

WORKDIR /var/www

#php php-gd php-apcu php-opcache php-common php-curl php-imagick
#php-intl php-mysql php-xdebug php-http php-xsl php-bcmath php-zip php-memcached
# git curl htop cron
RUN apt-get -y update && apt-get install -y imagemagick zlib1g-dev libyaml-dev libzip-dev libmagickwand-dev 

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY docker/php/php.ini $PHP_INI_DIR/php.ini-production
COPY docker/php/php-fpm.conf $PHP_INI_DIR/fpm/
COPY docker/php/pool.d/www.conf $PHP_INI_DIR/fpm/pool.d/

RUN pecl install imagick zip && \
    docker-php-ext-install gd pdo_mysql && \
    docker-php-ext-enable imagick gd zip && \
    docker-php-source delete

RUN echo "xdebug.idekey = XDEBUG_PHPSTORM" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.mode=debug" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.start_with_request=yes" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_host=host.docker.internal" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

RUN usermod -u 1000 www-data

FROM builder AS dev
RUN pecl install xdebug-2.9.0 && \
    docker-php-ext-enable xdebug && \
    docker-php-source delete
