FROM php:7.3.12-apache

MAINTAINER Alexander Sidorov

COPY . /srv/app
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN docker-php-ext-install mbstring pdo pdo_mysql \
        && chown -R www-data:www-data /srv/app
RUN if command -v a2enmod >/dev/null 2>&1; then \
        a2enmod rewrite headers \
    ;fi