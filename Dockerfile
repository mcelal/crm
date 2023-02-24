# Use official composer library to move the composer binary to the PHP container
FROM composer:latest AS composer

FROM php:8.1.16-apache

RUN apt update -y

# Install the PHP extension installer that will install and configure the extension, but will also install all dependencies.
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

# Install the ZIP extension since Composer requires it
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions zip

# Copy the composer binary to the container
COPY --from=composer /usr/bin/composer /usr/bin/composer
# Set composer home directory
ENV COMPOSER_HOME=/.composer
# Composer needs to run as root to allow the use of a bind-mounted cache volume
ENV COMPOSER_ALLOW_SUPERUSER=1

# Enable headers/rewrite module for Apache
RUN a2enmod headers rewrite

# Set document root for Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Create the project root folder and assign ownership to the pre-existing www-data user
RUN mkdir -p /var/www/html /.composer && chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

# Copy the rest of the source code to the container. Now, if source files are changed, the cache-layer
# breaks here and the only the 'composer dump-autoload' command will have to run again.
COPY --chown=www-data . /var/www/html/

# Generate an optimized autoloader after copying the source files to the container
# RUN composer dump-autoload --optimize

# Change ownership of the root folder to www-data
# RUN chown -R www-data:www-data vendor/