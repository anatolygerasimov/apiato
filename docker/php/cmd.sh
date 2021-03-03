#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then

    echo "Starting application and apply the latest migrations..."
    php /var/www/html/artisan migrate --force;

    echo "Linking storage folder..."
    rm -rf /var/www/html/public/storage;
    php /var/www/html/artisan storage:link;

    echo "Creating laravel cache"
    php /var/www/html/artisan route:cache;
    php /var/www/html/artisan config:cache;
    php /var/www/html/artisan view:cache;
    php /var/www/html/artisan event:cache;
    php-fpm;

elif [ "$role" = "queue" ]; then

    echo "Running the queue..."
    php /var/www/html/artisan queue:work --verbose --tries=3 --timeout=90;

else

    echo "Could not match the container role \"$role\""
    exit 1

fi
