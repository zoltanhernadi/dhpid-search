# DHPID
FROM php:8-apache-bullseye

LABEL name = 'DHPID Search'
LABEL maintainer = 'Xelerance - Mike Mallett'
LABEL email = 'mmallett@xelerance.com'

WORKDIR /var/www

RUN apt update
RUN DEBIAN_FRONTEND=noninteractive apt install -y git libpng-dev libxml2-dev libzip-dev libbz2-dev libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev libfreetype6-dev default-mysql-client ca-certificates
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
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

WORKDIR /var/www/dhpid-search

RUN composer install --prefer-dist --no-interaction --working-dir=/var/www/dhpid-search

# Setup credentials for database connections
COPY /docker/install.sh /
RUN chmod +x /install.sh

# Configure Apache HTTPD, which will be executed by install.sh
RUN cp /var/www/dhpid-search/apache_vhost.example /etc/apache2/sites-available/dhpid-search.conf
RUN a2dissite 000-default ; a2ensite dhpid-search
RUN a2enmod rewrite

# Setup a self-signed TLS certificate for HTTPS
RUN mkdir -p /etc/apache2/ssl/certs ; chmod 0755 /etc/apache2/ssl/certs ; mkdir -p /etc/apache2/ssl/private ; chmod 0700 /etc/apache2/ssl/private
RUN openssl req -new -x509 -days 3650 -nodes -out /etc/apache2/ssl/certs/dhpid-search.crt -keyout /etc/apache2/ssl/private/dhpid-search.key -subj "/C=IN/ST=HC-SC/L=Ottawa/O=HC-SC/CN=dhpid.jack.hc-sc.gc.ca"
RUN sed -i 's|<VirtualHost \*:443>|<VirtualHost *:443>\n\tSSLEngine On\n\tSSLCertificateFile /etc/apache2/ssl/certs/dhpid-search.crt\n\tSSLCertificateKeyFile /etc/apache2/ssl/private/dhpid-search.key\n|' /etc/apache2/sites-available/dhpid-search.conf
RUN a2enmod ssl

# END: Please execute /install.sh during container create/start/run.
