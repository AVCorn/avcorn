FROM composer as builder
WORKDIR /app/

COPY ./code/composer.* ./

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist


FROM php:8.2-cli
WORKDIR /usr/src/app

RUN apt update && apt install -y curl

COPY --from=builder . ./lib/composer
COPY ./code/ .

RUN php -S 0.0.0.0:8080 -t public