#!/bin/bash
set -e

echo "=== Starting Laravel Application ==="

# Esperar a la base de datos (máximo 30 intentos = 1 minuto)
max_attempts=30
attempt=0

until php artisan db:show > /dev/null 2>&1 || [ $attempt -eq $max_attempts ]; do
    echo "Waiting for database... ($((attempt+1))/$max_attempts)"
    sleep 2
    attempt=$((attempt+1))
done

# Ejecutar migraciones si la DB está lista
if [ $attempt -lt $max_attempts ]; then
    echo "Running migrations..."
    php artisan migrate --force
fi

# Limpiar cache de configuración (NO cachear por el error de Closure)
php artisan config:clear

# Iniciar servidor
echo "Starting server on port ${PORT:-8080}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}