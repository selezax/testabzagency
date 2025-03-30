FROM node:latest AS node
FROM php:8.4-fpm AS ABZ

WORKDIR /var/www

# Установка всех зависимостей за один проход
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libmemcached-dev \
    libssl-dev \
    zlib1g-dev \
    imagemagick \
    libmagickwand-dev \
    libomp-dev \
    locales \
    zip \
    unzip \
    git \
    curl \
    vim \
    mc \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    --no-install-recommends \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка PHP-расширений
RUN docker-php-ext-install pdo_mysql exif pcntl bcmath gd

# Установка memcached
RUN pecl install memcached-3.2.0 \
    && docker-php-ext-enable memcached

# Установка imagick из исходников
RUN apt-get update && apt-get install -y git \
    && git clone https://github.com/Imagick/imagick.git /tmp/imagick \
    && cd /tmp/imagick \
    && git checkout 3.6.0 \
    && phpize \
    && ./configure --with-imagick=/usr \
    && make \
    && make install \
    && docker-php-ext-enable imagick \
    && rm -rf /tmp/imagick \
    && php -m | grep imagick

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Создание пользователя www
RUN groupadd -g 1000 www \
    && useradd -u 1000 -ms /bin/bash -g www www

# Копирование приложения с правильными правами
COPY --chown=www:www . /var/www

# Установка Node.js и NPM
COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# Переключение на пользователя www
USER www

EXPOSE 9000
CMD ["php-fpm"]
