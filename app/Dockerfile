FROM php:8.0-cli

WORKDIR /app

COPY . /app

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN composer install

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]