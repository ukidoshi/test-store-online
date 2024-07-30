docs: https://documenter.getpostman.com/view/15521620/2sA3kbexMj#7c88ada8-754f-41b2-a6e6-69cfccd54dcd

Развернуть
cp .env.example .env
composer update
php artisan key:generate
./vendor/bin/sail up
