#!/bin/bash

# Ожидание запуска базы данных
until nc -z -v -w30 mysql 3306
do
  echo "Ожидание запуска базы данных..."
  sleep 5
done

echo "База данных доступна, продолжаем выполнение..."

# Запуск Laravel миграций
php artisan migrate --force
php artisan key:generate
php artisan storage:link
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/bootstrap/cache

exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
