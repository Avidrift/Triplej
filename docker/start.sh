#!/bin/bash
set -e

echo "=== Starting Laravel Application ==="

# Configurar Nginx con el puerto correcto
envsubst '${PORT}' < /etc/nginx/sites-available/default > /etc/nginx/sites-available/default.tmp
mv /etc/nginx/sites-available/default.tmp /etc/nginx/sites-available/default

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

# Limpiar y optimizar
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Crear link de storage si no existe
php artisan storage:link || true

# Iniciar servicios con Supervisor
echo "Starting Nginx and PHP-FPM on port ${PORT:-8080}..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
