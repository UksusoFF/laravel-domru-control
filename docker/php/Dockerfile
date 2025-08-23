FROM php:8.4-fpm

WORKDIR /var/www/api

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    curl \
    zip unzip \
    jpegoptim optipng pngquant gifsicle libwebp-dev \
    libpq-dev \
    libicu-dev \
    git \
    mariadb-client-compat

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mbstring zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg  --with-webp
RUN docker-php-ext-install gd
RUN docker-php-ext-install exif
RUN docker-php-ext-install pdo pdo_pgsql pgsql
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install pdo pdo_mysql

#RUN pecl install xdebug-3.3 && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

USER www

COPY docker/php/entry.sh /var/tmp

EXPOSE 9000

ENTRYPOINT /var/tmp/entry.sh
