#!/bin/bash

set -e

source /var/www/.env

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

if [[ "$role" = "app" ]]; then

    cd /var/www
    composer install

    php-fpm -R -F
fi
