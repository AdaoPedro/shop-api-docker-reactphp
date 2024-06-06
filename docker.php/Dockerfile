FROM php:8.3.7

WORKDIR /app

COPY ./composer.* /app/

COPY --from=composer:lts /usr/bin/composer /user/bin/composer

RUN composer install

COPY ./public /app/
COPY ./src /app/

RUN composer dump-autoload

CMD php server.php