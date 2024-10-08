FROM dunglas/frankenphp:latest-bookworm

RUN install-php-extensions \
    pdo_pgsql \
    pcntl \
    redis

COPY . /app
