FROM php:8.3-fpm

# Instalar dependencias del sistema y Node.js
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    gettext-base \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de PHP con autoload optimizado
RUN composer install --optimize-autoloader --no-dev --no-interaction && \
    composer dump-autoload --optimize --classmap-authoritative

# Instalar dependencias de Node y compilar assets
RUN npm ci && npm run build

# Crear directorios necesarios para logs y cache
RUN mkdir -p storage/logs \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    /var/log/supervisor

# Dar permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Configurar Nginx
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Configurar Supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copiar script de inicio
COPY docker/start.sh /usr/local/bin/start.sh
RUN sed -i 's/\r$//' /usr/local/bin/start.sh && \
    chmod +x /usr/local/bin/start.sh

# Exponer puerto
EXPOSE 8080

CMD ["/usr/local/bin/start.sh"]