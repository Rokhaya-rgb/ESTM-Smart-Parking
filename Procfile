web: php artisan serve --host=0.0.0.0 --port=$PORT
postdeploy: php artisan storage:link && php artisan migrate:fresh --force && php artisan db:seed --force
