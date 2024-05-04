FROM php:8.2

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/api

COPY . .

RUN chown -R www-data:www-data \
    /var/www/api/storage \
    /var/www/api/bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=8000
