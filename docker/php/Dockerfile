FROM php:8.1-apache
RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html