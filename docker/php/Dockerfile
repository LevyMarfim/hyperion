FROM php:8.4-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    libpq-dev \
    libicu-dev \
    && docker-php-ext-install intl pdo_pgsql zip mbstring exif opcache \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    # Install APCu (userland caching)
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    # Install Xdebug (debugging)
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Copy OPcache configuration
COPY ./conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
# Copy Xdebug and APCu configs
COPY ./conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./conf.d/apcu.ini /usr/local/etc/php/conf.d/apcu.ini

# Set PHP timezone
RUN echo "date.timezone = America/Fortaleza" > /usr/local/etc/php/conf.d/timezone.ini

EXPOSE 9000
