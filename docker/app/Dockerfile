# PHP
FROM php:7.4.0-fpm-buster

# update APT sources
RUN apt-get update --fix-missing

# PHP extensions
RUN docker-php-ext-install pdo_mysql

# Composer
RUN apt-get install -y curl software-properties-common git zip unzip wget libxrender1 libfontconfig libxext6 libssl-dev
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer





