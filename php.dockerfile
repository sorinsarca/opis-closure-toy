ARG IMAGE=php:rc-fpm-alpine
FROM $IMAGE

RUN apk add --no-cache --virtual .persistent-deps libffi-dev \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-configure ffi --with-ffi \
    && docker-php-ext-install ffi \
    && docker-php-ext-install opcache
