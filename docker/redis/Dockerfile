FROM redis:latest

# Копируем кастомные настройки Redis
COPY redis.conf /usr/local/etc/redis/redis.conf

# Запускаем Redis с кастомной конфигурацией
CMD ["redis-server", "/usr/local/etc/redis/redis.conf"]
