FROM php:8.2-fpm-alpine

# Устанавливаем PostgreSQL поддержку
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Создаем не-root пользователя для безопасности
RUN adduser -D -u 1000 www-data

# Переключаемся на не-root пользователя
USER www-data

# Рабочая директория
WORKDIR /var/www/html
