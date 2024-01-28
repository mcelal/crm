#!/bin/bash

# docker run -it --rm -v .:/var/www/html serversideup/php:8.2-cli /bin/sh -c "./deploy.sh"

echo -e "----------------"
echo -e "START DEPLOY !!!"
echo -e "----------------\n\n"

composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader --no-scripts

echo -e "\n\n"

echo -e "Run Cache Clear:"
php artisan config:clear
php artisan cache:clear

echo -e "Run Optimize:"
php artisan optimize:clear
php artisan optimize

echo -e "Run Migration:"
php artisan migrate
