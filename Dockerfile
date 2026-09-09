# Monta imagem do PHP
FROM php:8.5-fpm


RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    && rm -rf /var/lib//apt/lists/*


RUN docker-php-ext-install mbstring pdo_mysql zip

RUN pecl install pcov && docker-php-ext-enable pcov

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN chown -R www-data:www-data /var/www

USER www-data

EXPOSE 9000

