FROM composer:latest AS composer

FROM node:18 AS node

FROM php:8.4.1-fpm AS base
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV ACCEPT_EULA=Y
ENV DEBIAN_FRONTEND=noninteractive

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    libpq-dev \
    libzip-dev \
    htop \
    vim \
    cron \
    supervisor \
    git \
    libwebp-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libgd-dev \
    jpegoptim \
    optipng \
    pngquant \
    unzip \
    gifsicle \
    libxml2-dev \
    && pecl install -o -f redis xdebug \
    && docker-php-ext-enable redis xdebug \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure gd --enable-gd --with-webp --with-jpeg --with-freetype \
    && docker-php-ext-install -j$(nproc) exif gd zip pdo pdo_pgsql ftp bcmath xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && mkdir -p /var/log/supervisor

RUN { \
    echo "upload_max_filesize = 16M"; \
    echo "post_max_size = 64M"; \
    echo "max_execution_time = -1"; \
    echo "memory_limit = -1"; \
    echo "[PHP]"; \
    echo "date.timezone = \"America/Bahia\""; \
    } > /usr/local/etc/php/conf.d/custom.ini \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY --from=node /usr/local/bin /usr/local/bin
COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules

COPY ./docker/NGINX/default.conf /etc/nginx/sites-available/default

RUN rm -f /etc/nginx/sites-enabled/default \
    && ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

COPY ./docker/SUPERVISOR/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY --chown=www-data:www-data . .
RUN chmod +x ./permissions.sh \
    && ./permissions.sh

RUN composer install --no-dev --no-interaction --no-progress --no-suggest --optimize-autoloader \
    && composer clear-cache \
    && npm i \
    && npm i -g npm@latest npx gulp-cli cross-env sass postcss-cli autoprefixer

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
