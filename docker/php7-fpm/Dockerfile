FROM ubuntu:16.04

RUN apt-get -y update && apt-get install -y vim php  php-apcu php-cli  php-opcache  php-common  php-curl  php-fpm  php-imagick  php-intl  php-mysql  php-xdebug  php-http  php-xsl php-bcmath php-mbstring php-zip php-memcached imagemagick git curl htop cron

RUN echo "xdebug.idekey = XDEBUG_PHPSTORM" >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo "xdebug.remote_port=9001" >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo "xdebug.remote_enable=1" >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo "xdebug.remote_connect_back = On" >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo "xdebug.max_nesting_level = 300" >> /etc/php/7.0/mods-available/xdebug.ini

ADD php.ini /etc/php/7.0/fpm/
ADD php-fpm.conf /etc/php/7.0/fpm/
ADD pool.d/www.conf /etc/php/7.0/fpm/pool.d/
RUN mkdir /run/php && chmod 777 /run/php
RUN usermod -u 1000 www-data

EXPOSE 9000
ENTRYPOINT ["/usr/sbin/php-fpm7.0", "-F"]
