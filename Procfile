release: php artisan migrate --force && php artisan config:clear && php artisan view:clear && php artisan cache:clear
web: heroku-php-nginx -C nginx.conf public/
