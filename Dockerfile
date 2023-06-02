# We specify the base image we need for our
# application. PHP 8.1 comes with Apache preinstalled
FROM php:8.1-apache

# Copy the application directory contents into the Docker image
COPY ./ /var/www/

# We specify the document root for Apache
WORKDIR /var/www/

# Copy .env file
COPY ./.env /var/www/

# Installing git, zip, and unzip
RUN apt-get update && apt-get install -y git zip unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Add the necessary PHP extensions based on DB_DRIVER
ARG DB_DRIVER
RUN if [ "$DB_DRIVER" = "mysql" ] ; then docker-php-ext-install pdo_mysql ; fi
RUN if [ "$DB_DRIVER" = "pgsql" ] ; then apt-get install -y libpq-dev && docker-php-ext-install pdo_pgsql ; fi

# Install project dependencies
RUN composer install -vvv

# Expose port 80
EXPOSE 80

# Configuring apache
RUN a2enmod rewrite headers
# ADD vhost.conf /etc/apache2/sites-available/000-default.conf

# Start Apache service
CMD apachectl -D FOREGROUND