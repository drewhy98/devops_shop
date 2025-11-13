# Builds PHP + Apache app
FROM php:8.2-apache

# Install mysqli and other common PHP extensions
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy app files
COPY ./site /var/www/html

EXPOSE 80
