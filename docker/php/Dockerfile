FROM php:8.1-fpm

RUN apt-get update
RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN pecl install mongodb && docker-php-ext-enable mongodb

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --no-interaction

COPY src/composer.json /var/www/html
COPY src/composer.lock /var/www/html

RUN apt-get update && apt-get install -y git
RUN composer install

