FROM php:8.3.7

WORKDIR /app

COPY ./composer.* /app/

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions @composer

COPY ./public /app/
COPY ./src /app/

RUN composer install

RUN composer dump-autoload

CMD php server.php