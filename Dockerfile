FROM php:8.2-fpm-alpine

# Устанавливаем PostgreSQL поддержку
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Пользователь www-data уже существует в базовом образе
# Просто переключаемся на него
USER www-data

# Рабочая директория
WORKDIR /var/www/html
