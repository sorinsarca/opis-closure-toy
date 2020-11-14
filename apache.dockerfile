ARG IMAGE=php:7.4-apache
FROM $IMAGE

RUN apt-get update && apt-get install -y libffi-dev \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-configure ffi --with-ffi \
    && docker-php-ext-install ffi \
    && docker-php-ext-install opcache

RUN echo "Listen 8586" > /etc/apache2/ports.conf
RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf
RUN a2enconf fqdn

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
