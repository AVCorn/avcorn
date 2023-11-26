FROM composer:2.2 as vendor

WORKDIR /app

COPY ./code/composer.json composer.json
COPY ./code/composer.lock composer.lock

RUN composer install \
    --prefer-dist

COPY ./code/ .
RUN composer dump-autoload


FROM php:8.2-apache
WORKDIR /var/www/html

RUN apt update
RUN apt install -y curl git

COPY --from=vendor app/vendor/ ./vendor/
COPY ./code/ .

RUN a2enmod rewrite

#COPY my-apache-site.conf /etc/apache2/sites-available/my-apache-site.conf

#RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
#    a2dissite 000-default && \
#    a2ensite my-apache-site && \
#    service apache2 restart

#RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ && \
#    docker-php-ext-install gd

RUN service apache2 restart

EXPOSE 80
