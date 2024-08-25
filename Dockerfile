# Usa una imagen base de PHP
FROM php:8.1-cli

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
    libicu-dev \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Instala extensiones de PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_pgsql

# Instala Composer


# Configura el directorio de trabajo
WORKDIR /app

# Copia los archivos de tu proyecto al contenedor
COPY . .

# Instala dependencias de Composer


# Copia el archivo .env
COPY .env.example .env

# Da permisos a las carpetas necesarias
RUN mkdir -p /app/storage/logs
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Expone el puerto 8000 para PHP
EXPOSE 8000

# Inicia el servidor integrado de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
