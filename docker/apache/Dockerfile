# Imagen base con Apache y PHP
FROM php:8.1-apache

# Habilitamos el módulo de reescritura de Apache (útil para Laravel)
RUN a2enmod rewrite

# Instalamos la extensión pdo_mysql para la conexión a MySQL
RUN docker-php-ext-install pdo_mysql

# Configuración de puertos
EXPOSE 80

# Copiamos el código fuente de PHP a la carpeta donde Apache espera servir archivos
# COPY ./src /var/www/html/

# Configuración de permisos adecuados
RUN chown -R www-data:www-data /var/www/html