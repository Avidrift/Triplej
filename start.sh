#!/bin/bash
set -e

echo "Waiting for database..."

max_attempts=30
attempt=0

until php artisan db:show > /dev/null 2>&1 || [ $attempt -eq $max_attempts ]; do
    echo "Database not ready, waiting... (attempt $((attempt+1))/$max_attempts)"
    sleep 2
    attempt=$((attempt+1))
done

if [ $attempt -eq $max_attempts ]; then
    echo "Database not available after $max_attempts attempts"
    echo "Starting server without migrations..."
else
    echo "Database ready! Running migrations..."
    php artisan migrate --force
    echo "Migrations completed successfully!"
fi

echo "Caching configuration..."
php artisan config:cache

echo "Starting server on port ${PORT:-8080}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}