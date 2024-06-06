FROM php:8.3.7

WORKDIR /app

COPY ./composer.* /app/

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions @composer

RUN composer install

COPY ./src /app/
COPY ./public /app/

RUN composer dump-autoload

CMD php public/server.php