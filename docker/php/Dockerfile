FROM php:7.4-fpm as application_background

# Dependencies
RUN DEBIAN_FRONTEND=noninteractive apt-get update && apt-get install -y \
    libgmp-dev libmcrypt-dev libpng-dev libonig-dev libxml2-dev \
    zip unzip cron libzip-dev && \
    apt-get clean && rm -rf /var/lib/apt/lists/* && \
    # install php extensions
    docker-php-ext-install pdo_mysql exif pcntl zip intl tokenizer bcmath gd && \
    docker-php-ext-install opcache && \
    pecl install -o -f redis && rm -rf /tmp/pear &&  docker-php-ext-enable redis && \
    # install composer
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer && \
    rm composer-setup.php

# COPY ./docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./docker/php/conf.d/laravel.ini /usr/local/etc/php/conf.d/laravel.ini

ENV LANG="en_US.UTF-8 LC_ALL=en_US.UTF-8"


FROM application_background as application

COPY ./ /var/www/html
WORKDIR /var/www/html

# run composer install
RUN composer install --no-dev -n --no-progress --ignore-platform-reqs --optimize-autoloader && \
    composer clear-cache && \
    chown www-data:www-data /var/www/html/vendor && \
    chmod -R 777 /var/www/html/storage /var/www/html/bootstrap && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap
COPY ./docker/php/cmd.sh /usr/local/bin/cmd
RUN chmod u+x /usr/local/bin/cmd
USER root
RUN chsh www-data -s /usr/sbin/nologin && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

FROM application as viator_app_dev
CMD ["php-fpm"]

FROM application as viator_app
CMD ["/usr/local/bin/cmd"]
