FROM composer:latest AS composer

FROM node:22 AS node

FROM php:8.4.5-fpm AS base
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV ACCEPT_EULA=Y
ENV DEBIAN_FRONTEND=noninteractive
ENV APP_ENV=${APP_ENV}
ARG APP_ENV=development

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    libpq-dev \
    libzip-dev \
    htop \
    vim \
    nano \
    cron \
    supervisor \
    git \
    libwebp-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libicu-dev \
    libgd-dev \
    jpegoptim \
    optipng \
    pngquant \
    unzip \
    gifsicle \
    libxml2-dev \
    gnupg2 \
    wget \
    lsb-release \
    libcurl4-openssl-dev \
    && docker-php-ext-install pcntl \
    && pecl install -o -f redis xdebug \
    && docker-php-ext-enable redis xdebug \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure gd --enable-gd --with-webp --with-jpeg --with-freetype \
    && docker-php-ext-install -j$(nproc) exif gd zip curl pdo pdo_pgsql ftp bcmath xml intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN mkdir -p /var/log/nginx /var/log/php /var/log/supervisor \
    && touch /var/log/nginx/access.log /var/log/nginx/error.log \
    && touch /var/log/php_errors.log \
    && chmod -R 666 /var/log/nginx/*.log /var/log/php_errors.log


RUN echo "upload_max_filesize = 16M" > /usr/local/etc/php/conf.d/custom.ini && \
    echo "post_max_size = 64M" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "max_execution_time = 60" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "memory_limit = 512M" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "expose_php = Off" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "log_errors = On" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "error_log = /var/log/php_errors.log" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "disable_functions = exec,passthru,shell_exec,system,parse_ini_file,show_source" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "date.timezone = America/Bahia" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.enable_cli=1" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.validate_timestamps=1" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.revalidate_freq=2" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.jit=tracing" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.jit_buffer_size=100M" >> /usr/local/etc/php/conf.d/custom.ini && \
    if [ "$APP_ENV" = "production" ] || [ "$APP_ENV" = "staging" ]; then echo "display_errors = Off"; else echo "display_errors = On"; fi >> /usr/local/etc/php/conf.d/custom.ini


RUN touch /var/log/php_errors.log && chmod 666 /var/log/php_errors.log \
    && echo "0 0 * * 0 truncate -s 0 /var/log/php_errors.log" > /etc/cron.d/clean_php_log \
    && chmod 0644 /etc/cron.d/clean_php_log \
    && crontab /etc/cron.d/clean_php_log

RUN echo "deb [signed-by=/usr/share/keyrings/postgresql-keyring.gpg] http://apt.postgresql.org/pub/repos/apt/ $(lsb_release -cs)-pgdg main" > /etc/apt/sources.list.d/pgdg.list && \
    wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | gpg --dearmor -o /usr/share/keyrings/postgresql-keyring.gpg \
    && apt-get update && apt-get install -y --no-install-recommends postgresql-client && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

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

RUN composer install --no-interaction --no-progress --optimize-autoloader \
    && composer clear-cache \
    && npm i -g npm@latest npx gulp-cli cross-env postcss-cli autoprefixer \
    && npm install laravel-vite-plugin@^1.0.0 --save-dev eslint-define-config \
    && npm install \
    && npm audit fix --force

RUN git config --global --add safe.directory /var/www/html

# XDEBUG só será ativado se a variável de ambiente PHP_ENABLE_XDEBUG=1 estiver setada.
# Isso evita conflitos com o JIT e melhora performance geral.
# Em produção ou desenvolvimento comum, deixe desativado (padrão).
ENTRYPOINT ["/bin/sh", "-c"]
CMD ["[ \"$PHP_ENABLE_XDEBUG\" = \"1\" ] && echo 'zend_extension=xdebug.so' > /usr/local/etc/php/conf.d/zzz-xdebug.ini; exec supervisord -c /etc/supervisor/conf.d/supervisord.conf"]
