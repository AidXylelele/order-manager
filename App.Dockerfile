FROM node:latest as vite-builder

WORKDIR /var/www/vite

COPY package*.json .

COPY vite.config.js .

COPY ./resources ./resources

COPY ./public/ ./public

RUN npm ci

RUN npm run build



FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libssl-dev \
    pkg-config \
    libonig-dev \
    libzip-dev && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql exif pcntl gd

RUN groupadd -g 1000 www && \
    useradd -u 1000 -ms /bin/bash -g www www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/

COPY  --chown=www:www . .

COPY  --chown=www:www --from=vite-builder /var/www/vite .

RUN composer install --prefer-dist

USER www

EXPOSE 9000
CMD ["php-fpm"]
