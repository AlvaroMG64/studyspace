FROM php:8.2-apache

RUN a2enmod rewrite

RUN docker-php-ext-install mysqli pdo pdo_mysql

# COPIAR PRIMERO
COPY . /var/www/html/

# CAMBIAR DOCUMENT ROOT EN VHOST (CLAVE)
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# también en apache config general
RUN sed -i 's|/var/www/|/var/www/html/public|g' /etc/apache2/apache2.conf

# permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80