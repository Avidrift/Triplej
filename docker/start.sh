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

# Ejecutar migraciones
if [ $attempt -lt $max_attempts ]; then
    echo "Running migrations..."
    php artisan migrate --force
fi

# Limpiar caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Crear link de storage
php artisan storage:link || true

# Verificar Nginx
nginx -t

# Iniciar servicios
echo "Starting Nginx and PHP-FPM on port 8080..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
