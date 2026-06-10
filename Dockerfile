FROM php:8.2-apache

# Habilitar mod_rewrite (importante para routers tipo MVC)
RUN a2enmod rewrite

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar todo el proyecto al servidor web
COPY . /var/www/html/

# Dar permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Permitir .htaccess (por si luego lo usas)
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Puerto de Apache en Render
EXPOSE 80