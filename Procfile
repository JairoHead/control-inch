release: php artisan migrate --force && php artisan config:clear && php artisan view:clear && php artisan cache:clear
start: node /assets/scripts/prestart.mjs /assets/nginx.template.conf /nginx.conf && (php-fpm -y /assets/php-fpm.conf & nginx -c /nginx.conf)
