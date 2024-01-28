# Used for prod build.
FROM serversideup/php:8.2-fpm-nginx as base

RUN apt-get update \
    && apt-get install -y --no-install-recommends php8.2-pgsql git \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    && git config --global --add safe.directory /var/www/html

ENV AUTORUN_ENABLED=false
ENV SSL_MODE=off

RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader --no-scripts

# Run the entrypoint file.
EXPOSE 80
EXPOSE 443

ENTRYPOINT ["/init"]
