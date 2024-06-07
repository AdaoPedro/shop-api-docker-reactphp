FROM php:8.3.7

WORKDIR /app

COPY ./composer.* /app/

# Install Docker and its deps (i.e. git)
COPY --from=composer:lts /usr/bin/composer /usr/local/bin/composer
RUN apt-get update -y
RUN apt-get install -y git

# Install and enable pcntl extension (for PHP Watcher)
RUN docker-php-ext-configure pcntl --enable-pcntl && docker-php-ext-install pcntl;

# Install composer deps
RUN composer install --ignore-platform-reqs --prefer-dist --no-interaction --no-progress

# Copy app files
COPY ./src /app/
COPY ./public /app/
COPY ./.php-watcher.yml /app/

# Update composer.json file
RUN composer dump-autoload --optimize

# Start server using php-watcher
CMD composer run-php-watcher