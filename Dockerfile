FROM php:8.2-apache

# =========================
# MODULOS APACHE
# =========================
RUN a2enmod rewrite

# =========================
# EXTENSIONES PHP
# =========================
RUN docker-php-ext-install mysqli pdo pdo_mysql

# =========================
# COPIAR PROYECTO
# =========================
COPY . /var/www/html/

# =========================
# APACHE CONFIG (IMPORTANTE)
# =========================

# permitir .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# document root correcto
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# =========================
# PERMISOS
# =========================
RUN chown -R www-data:www-data /var/www/html

# =========================
# PUERTO
# =========================
EXPOSE 80