FROM php:8.3-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app

RUN sed -i 's/http:/https:/gi' /etc/apt/sources.list.d/debian.sources

# git, unzip & zip are for composer
RUN apt-get update -qq && \
    apt-get install -qy \
    git \
    gnupg \
    unzip \
    zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# PHP Extensions
RUN docker-php-ext-install -j$(nproc) opcache pdo_mysql
COPY conf/php.ini /usr/local/etc/php/conf.d/app.ini

RUN pecl install xdebug apcu \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable apcu \
    && docker-php-ext-install opcache

# Apache
COPY conf/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY conf/apache.conf /etc/apache2/conf-available/z-app.conf

RUN a2enmod rewrite remoteip && \
    a2enconf z-app