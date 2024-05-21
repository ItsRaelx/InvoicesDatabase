# Use a base image
FROM php:8.3-cli-alpine

WORKDIR /var/www/html

# Install necessary packages
RUN apk update && apk add --no-cache \
    bash \
    curl \
    libpng \
    libjpeg \
    icu \
    zip \
    libzip \
    nodejs \
    npm \
    && apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    libpng-dev \
    libjpeg-turbo-dev \
    icu-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd intl opcache pdo pdo_mysql zip mysqli \
    && pecl install apcu \
    && pecl install xlswriter \
    && docker-php-ext-enable apcu xlswriter \
    && apk del .build-deps

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy all project files into the container
COPY . .

# Set script.sh as executable
RUN chmod +x script.sh

# Install Composer dependencies
RUN composer install --ignore-platform-req=ext-xlswriter --ignore-platform-req=ext-gd --no-scripts --no-autoloader

# Install Node.js dependencies and Vite
RUN npm install -g vite \
    && npm install laravel-vite-plugin

# Add Vite to PATH
ENV PATH="/var/www/html/node_modules/.bin:${PATH}"

# Check Vite installation
RUN vite --version

EXPOSE 8000

ENTRYPOINT ["sh", "-c", "composer install && /bin/bash /var/www/html/script.sh"]