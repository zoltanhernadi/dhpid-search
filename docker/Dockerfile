# DHPID
FROM php:7.3.27-apache-stretch
#FROM ubuntu:20.04

LABEL name = 'DHPID'
LABEL maintainer = 'Xelerance - Mike Mallett'
LABEL email = 'mmallett@xelerance.com'

WORKDIR /var/www

RUN apt update
RUN DEBIAN_FRONTEND=noninteractive apt install -y git libpng-dev libxml2-dev libzip-dev libbz2-dev libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev libfreetype6-dev mysql-client
RUN docker-php-ext-configure gd --with-gd --with-webp-dir --with-jpeg-dir --with-png-dir --with-zlib-dir --with-xpm-dir --with-freetype-dir
RUN docker-php-ext-install pdo_mysql mysqli gd opcache zip
RUN rm -rf /var/lib/apt/lists/*

# Composer recommended settings
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_VERSION 2.0.12
ENV COMPOSER_MEMORY_LIMIT 1024M
ENV COMPOSER_EXIT_ON_PATCH_FAILURE 1

# Check Composer
RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer; \
    curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig; \
    php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }"

# Install Composer
RUN php /tmp/composer-setup.php --no-ansi \
                                --install-dir=/usr/local/bin \
                                --filename=composer \
                                --version=${COMPOSER_VERSION}; \
rm -rf /tmp/composer-setup.php

COPY /content/ /var/www/dhpid-search/

# TODO: Update this with an appropriate source path
#COPY /path/to/dhpid-search-dotenv /var/www/dhpid-search/.env

WORKDIR /var/www/dhpid-search

RUN composer install --prefer-dist --no-interaction --working-dir=/var/www/dhpid-search

# Set Laravel filesystem permissions
RUN chgrp -R www-data /var/www/dhpid-search ; touch /var/www/dhpid-search/storage/logs/laravel.log ; chmod g+w /var/www/dhpid-search/storage/logs/laravel.log ; chown -R www-data /var/www/dhpid-search/storage/framework/cache ; chown -R www-data /var/www/dhpid-search/storage/framework/sessions ; chown -R www-data /var/www/dhpid-search/storage/framework/views

# This can only be executed after the .env file has been setup with the appropriate credentials:
#RUN php artisan key:generate ; php artisan config:cache

RUN cp /var/www/dhpid-search/apache_vhost.example /etc/apache2/sites-available/dhpid-search.conf
RUN a2dissite 000-default ; a2ensite dhpid-search
CMD ["apache2-foreground"]
