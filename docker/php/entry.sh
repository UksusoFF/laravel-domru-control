#!/bin/bash
set -e

source "/var/www/api/.env"

cd "/var/www/api"

#if [ ! -f "/var/www/api/vendor/autoload.php" ]; then
  #composer install
#fi

#php artisan cache:clear

#php artisan migrate --force

#php artisan route:clear
#php artisan view:clear
#php artisan config:clear

nohup php artisan schedule:work &>> /var/www/api/storage/logs/artisan.log &

php-fpm
