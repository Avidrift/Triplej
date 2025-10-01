FROM php:8.3-cli

# Instalar dependencias del sistema
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

# Instalar dependencias de PHP
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Dar permisos a storage y bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Copiar el script de inicio y convertir line endings
COPY start.sh /usr/local/bin/start.sh
RUN sed -i 's/\r$//' /usr/local/bin/start.sh && \
    chmod +x /usr/local/bin/start.sh

# NO cachear nada en build time, solo en runtime

# Exponer puerto (Railway usa variable $PORT)
EXPOSE ${PORT:-8080}

# Healthcheck para verificar que el servidor esté respondiendo
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s \
  CMD curl -f http://localhost:${PORT:-8080}/up || exit 1

# Usar el script de inicio
CMD ["/usr/local/bin/start.sh"]