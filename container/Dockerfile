FROM composer:2.2 as vendor

WORKDIR /app

COPY ./code/composer.json composer.json
COPY ./code/composer.lock composer.lock

RUN composer install \
    --prefer-dist

COPY ./code/ .
RUN composer dump-autoload


FROM php:8.2-apache
WORKDIR /var/www/

RUN apt-get update
RUN apt-get install -y curl git --no-install-recommends \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=vendor app/vendor/ ./vendor/
COPY ./code/ .
COPY ./_env/ ./_env/

RUN chmod a+rwx -R backend/cache/

RUN a2enmod rewrite

COPY container/configs/apache.conf /etc/apache2/sites-available/avcorn.conf

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    a2dissite 000-default && \
    a2dissite default-ssl && \
    a2ensite avcorn && \
    service apache2 restart

#RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ && \
#    docker-php-ext-install gd

RUN service apache2 restart

EXPOSE 80
