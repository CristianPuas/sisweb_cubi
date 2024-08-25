# Usa una imagen base de PHP
FROM php:8.1-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    libxml2-dev

# Instala extensiones de PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_pgsql

# Instala Composer


# Configura el directorio de trabajo
WORKDIR /var/www

# Copia los archivos de tu proyecto al contenedor
COPY . .

# Instala dependencias de Composer


# Expone el puerto 9000
EXPOSE 9000

# Inicia PHP-FPM
CMD ["php-fpm"]
