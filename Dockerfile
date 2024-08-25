# Usa una imagen base de PHP
FROM crsitianpuas32/sisweb_cubi:latest

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
    libxml2-dev \
    nginx \
    && rm -rf /var/lib/apt/lists/*

# Instala extensiones de PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_pgsql

# Instala Composer

# Configura Nginx
COPY ./nginx.conf /etc/nginx/nginx.conf
# Configura el directorio de trabajo
WORKDIR /app

# Copia los archivos de tu proyecto al contenedor
COPY . .
RUN rm -rf /app/vendor
RUN rm -rf /app/composer.lock
# Instala dependencias de Composer
COPY .env.example .env
RUN mkdir -p /app/storage/logs
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache
# Expone el puerto 9000
CMD php artisan serve:start --server="nginx" --host="0.0.0.0"
EXPOSE 80

# Inicia PHP-FPM


