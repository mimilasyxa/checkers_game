FROM php:8.4-fpm

# Установка необходимых расширений PHP для Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    supervisor \
    cron \
    unzip \
    git \
    netcat-openbsd \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath zip opcache \
    && rm -rf /var/lib/apt/lists/*


RUN docker-php-ext-install pcntl
RUN docker-php-ext-install exif
# Копирование исходного кода приложения
COPY --chown=www-data:www-data ./backend /var/www/html

# Установка рабочей директории
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html

# Настройка прав доступа для папок storage и bootstrap/cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod +x /var/www/html/entrypoint.sh

# Копирование Composer в контейнер
COPY --from=composer:2.6.5 /usr/bin/composer /usr/local/bin/composer

# Установка зависимостей Laravel
RUN composer install --no-dev --optimize-autoloader

COPY ./docker/php/supervisor/conf.d/* /etc/supervisor/conf.d/

RUN printf '* * * * * root cd /var/www/html && /usr/local/bin/php artisan schedule:run >> /var/log/cron.log 2>&1\n' >> /etc/cron.d/hello-cron
RUN touch /var/log/cron.log
RUN crontab /etc/cron.d/hello-cron
COPY ./docker/php/configs/* /usr/local/etc/php/conf.d/


USER root

