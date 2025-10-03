#!/bin/bash
set -e

echo "=== Starting Laravel Application ==="

# Esperar a la base de datos
max_attempts=30
attempt=0

until php artisan db:show > /dev/null 2>&1 || [ $attempt -eq $max_attempts ]; do
    echo "Waiting for database... ($((attempt+1))/$max_attempts)"
    sleep 2
    attempt=$((attempt+1))
done

if [ $attempt -eq $max_attempts ]; then
    echo "⚠️  Database connection failed after $max_attempts attempts"
    echo "Continuing anyway..."
fi

# Ejecutar migraciones
if [ $attempt -lt $max_attempts ]; then
    echo "Running migrations..."
    php artisan migrate --force
fi

# CRÍTICO: NO usar config:cache ni route:cache en Laravel 11/12
# Limpiar cualquier caché anterior
echo "Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cachear solo las vistas (esto sí es seguro)
echo "Caching views..."
php artisan view:cache

# Crear link de storage
echo "Creating storage link..."
php artisan storage:link || true

# Optimizar Filament
echo "Optimizing Filament..."
php artisan filament:optimize || true

# Dar permisos correctos
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Verificar configuración de Nginx
echo "Testing Nginx configuration..."
nginx -t

# Iniciar supervisord en foreground
echo "Starting services via Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf