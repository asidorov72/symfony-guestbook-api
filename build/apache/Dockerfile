FROM httpd:2.4.33-alpine
RUN apk update; \
    apk upgrade;
# Copy apache vhost file to proxy php requests to php-fpm container
COPY 000-default.conf /usr/local/apache2/conf/000-default.conf