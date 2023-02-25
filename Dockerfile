FROM openswoole/swoole:latest

### Install Extensions
#RUN docker-php-ext-install
#RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS imagemagick-dev libtool \
#    && pecl install imagick && docker-php-ext-enable imagick

### PHP Config
RUN touch "$PHP_INI_DIR/conf.d/custom.ini" \
    && echo "max_file_uploads=50;" >> "$PHP_INI_DIR/conf.d/custom.ini" \
    && echo "post_max_size=20M;" >> "$PHP_INI_DIR/conf.d/custom.ini" \
    && echo "upload_max_filesize=20M;" >> "$PHP_INI_DIR/conf.d/custom.ini" \
    && echo "memory_limit=256M;" >> "$PHP_INI_DIR/conf.d/custom.ini" \
    && echo "realpath_cache_size=16M;" >> "$PHP_INI_DIR/conf.d/custom.ini" \
    && echo "realpath_cache_ttl=600;" >> "$PHP_INI_DIR/conf.d/custom.ini"

### Copy App
COPY . /app
WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER=1

### Install Composer Dependency
RUN composer install --no-dev \
    && composer require laravel/octane \
    && php artisan octane:install --server=swoole

CMD ["php", "artisan octane:start --server=swoole --host=0.0.0.0 --port=80"]
EXPOSE 80
