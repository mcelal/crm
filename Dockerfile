FROM dunglas/frankenphp:latest-bookworm

RUN install-php-extensions \
    pdo_pgsql \
    pcntl \
    redis \
    zip \
    intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN cp .env.example .env

RUN composer install --no-interaction --no-scripts

RUN chmod -R 775 storage bootstrap/cache
