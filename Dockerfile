FROM php:8.3-fpm as base
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV ACCEPT_EULA=Y
ENV DEBIAN_FRONTEND=noninteractive
ARG user=www-data
ARG uid=1000

WORKDIR /var/www/html

RUN usermod -u $uid $user \
  && mkdir -p /home/$user/.composer \
  && chown -R $user:$user /var/www/html \
  && chown -R $user:$user /home/$user

RUN apt-get update && apt-get install -y \
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
  gifsicle \
  libxml2-dev \
  && pecl install -o -f redis xdebug \
  && docker-php-ext-enable redis xdebug \
  && docker-php-ext-configure zip \
  && docker-php-ext-configure gd --enable-gd --with-webp --with-jpeg --with-freetype \
  && docker-php-ext-install -j$(nproc) exif gd zip pdo pdo_pgsql ftp bcmath xml \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
  && usermod -u $uid $user \
  && mkdir -p /home/$user/.composer /var/log/supervisor \
  && chown -R $user:$user /var/www/html /home/$user

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

  
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=node:18 /usr/local/bin /usr/local/bin
COPY --from=node:18 /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN npm install -g npm@latest npx gulp-cli cross-env node-sass sass postcss-cli autoprefixer \
  && git config --global --add safe.directory /var/www/html

COPY ./docker/NGINX/default.conf /etc/nginx/sites-available/default
RUN rm -f /etc/nginx/sites-enabled/default \
  && ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default
COPY ./docker/SUPERVISOR/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY --chown=www-data:www-data . .
RUN chmod +x ./permissions.sh \
  && ./permissions.sh

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
