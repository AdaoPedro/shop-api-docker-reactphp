FROM php:8.3.7 as production

WORKDIR /app

COPY ./composer.* /app/

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Composer and its deps (i.e. git)
COPY --from=composer:lts /usr/bin/composer /usr/local/bin/composer
RUN apt-get update -y
RUN apt-get install -y git

# Install composer deps
RUN composer install --ignore-platform-reqs --prefer-dist --no-interaction --no-progress --no-scripts --no-dev
# RUN composer install --ignore-platform-reqs --prefer-dist --no-interaction

# Copy app files
COPY ./public /app/
COPY ./src /app/

# Update composer.json file
RUN composer dump-autoload --optimize

# Start server using php-watcher
CMD php public/server.php

FROM production as development

COPY ./composer.* /app/

RUN composer install --ignore-platform-reqs --prefer-dist --no-interaction

# Install and enable pcntl extension (for PHP Watcher)
RUN docker-php-ext-configure pcntl --enable-pcntl && docker-php-ext-install pcntl;

# Download PHPUnit
RUN apt-get install -y wget 
RUN wget https://phar.phpunit.de/phpunit-11.2.phar 

# Download PHPStan
COPY --from=ghcr.io/phpstan/phpstan:latest /composer/vendor/phpstan/phpstan/phpstan.phar /app/phpstan.phar

# Copy app files
COPY ./tests /app/
COPY ./.php-watcher.yml /app/
COPY ./phpunit.xml /app/

# Update composer.json file
RUN composer dump-autoload --optimize

# Start server using php-watcher
CMD composer run-php-watcher