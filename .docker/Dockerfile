FROM php:8.2-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/api/

# Set working directory
WORKDIR /var/www/api

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    locales \
    zip \
    unzip \
    vim \
    git \
    curl \
    libzip-dev \
    libpq-dev

# Download and install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Set Xdebug mode for code coverage
ENV XDEBUG_MODE=coverage

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www/api

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
