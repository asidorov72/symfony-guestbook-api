FROM ubuntu:18.04

# Declare environment variables here, so DevOps team will know how
# to configure your application.
# APP_NAME is used only internally - to configure the Apache server name
ENV \
  APP_ENV="dev" \
  APP_NAME="symfony-guestbook-api" \

  DATABASE_HOST="127.0.0.1" \
  DATABASE_PORT="3306" \
  DATABASE_USERNAME="root" \
  DATABASE_PASSWORD="" \
  DATABASE_NAME="symfony_guestbook_api"

# 1. Install required packages
RUN apt-get update

RUN DEBIAN_FRONTEND="noninteractive" apt-get install \
    --assume-yes \
    software-properties-common

RUN apt-get update

RUN add-apt-repository ppa:ondrej/php

RUN DEBIAN_FRONTEND="noninteractive" apt-get install \
        --assume-yes \
        --no-install-recommends \
        --no-install-suggests \
#       remove outdated packages
        --auto-remove \
#       do not upgrade versions - repeatable builds
#        --no-upgrade \
#       follows the list of packages to install
        ca-certificates \
        curl=7.58.0-2ubuntu3.8 \
        libapache2-mod-php7.4 \
        apache2 \
        composer

RUN apt-get install --assume-yes php7.4-curl php-xml php7.4-dom php7.4-xml php7.4-mysqlnd php7.4-mbstring php7.4-pdo php7.4-zip php7.4-intl \
    php7.4-xmlwriter php7.4-tokenizer php7.4-xdebug

RUN rm -rf /var/cache/apt/archives/* \
    && rm -rf /var/lib/apt/lists/* \
#   configure apache
    && a2enmod rewrite

COPY ./build/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN \
# secure env file
  echo "" > /var/www/html/.env \
  && rm /var/www/html/index.html

# Copy your application to Apache
COPY . /var/www/html/

WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html
RUN composer install

RUN apt-get update && apt-get dist-upgrade -y
RUN apt-get install mysql-server -y
RUN service mysql restart

# expose the http port
EXPOSE 80

# run it!
CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]


