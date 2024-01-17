FROM php:8.0.0-apache
ARG DEBIAN_FRONTEND=noninteractive
# Include alternative DB driver
# RUN docker-php-ext-install pdo
# RUN docker-php-ext-install pdo_mysql


RUN apt-get update \
    && apt-get install -y sendmail libpng-dev \
    && apt-get install -y libzip-dev \
    && apt-get install -y zlib1g-dev \
    && apt-get install -y libonig-dev \
    && apt-get install -y libmagickwand-dev \
    && pecl install imagick \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install gd \
    && a2enmod rewrite
