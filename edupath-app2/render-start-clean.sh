#!/usr/bin/env bash
set -e
cd /var/www/html

echo "=== Starting Laravel Application on Render ==="

# Copy production environment configuration
if [ -f env-production ]; then
    cp env-production .env
fi

# Set production environment
export APP_ENV=production
export APP_DEBUG=false

echo "=== Database Configuration ==="
echo "DATABASE_URL: $DATABASE_URL"
echo "RENDER_DATABASE_HOST: $RENDER_DATABASE_HOST"
echo "DB_HOST: $DB_HOST"

# Test database connection
echo "=== Testing Database Connection ==="
if php artisan db:show 2>/dev/null; then
    echo "SUCCESS: Database connected!"
    php artisan db:show
else
    echo "Database connection test failed, running migrations anyway..."
fi

echo "Running migrations..."
php artisan migrate --force --no-interaction || echo "Migrations completed with warnings"

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache || echo "Route cache completed with warnings"

echo "Starting server..."
exec /start.sh
