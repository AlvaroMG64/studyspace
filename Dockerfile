FROM php:8.2-apache

# Habilitar rewrite (importante para tu Router MVC)
RUN a2enmod rewrite

# Extensiones PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# CLAVE: cambiar el DOCUMENT ROOT a /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar proyecto
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80