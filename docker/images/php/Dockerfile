FROM php:8.1-fpm-alpine

WORKDIR /var/www

RUN apk add bash
RUN apk add curl

RUN apk update && apk add \
    build-base \
    vim

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN addgroup -g 3000 -S www && \
#    adduser -u 3000 -S www -G www
#
#USER www
#
#COPY --chown=www:www . /var/www

EXPOSE 9000