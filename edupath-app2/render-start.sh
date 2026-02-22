#!/usr/bin/env bash
set -e
cd /var/www/html

echo "=== Starting Laravel Application on Render ==="

# CRITICAL: Render must provide DATABASE_URL (Internal Database URL from your PostgreSQL service)
if [ -z "$DATABASE_URL" ]; then
    echo ""
    echo "ERROR: DATABASE_URL is not set!"
    echo "Add it in Render: Environment -> DATABASE_URL = (Internal Database URL from your PostgreSQL)"
    echo ""
    exit 1
fi

# Copy production environment configuration
if [ -f env-production ]; then
    cp env-production .env
fi

# CRITICAL: Ensure APP_KEY is set (Laravel requires it for encryption/sessions/cookies)
if [ -z "$APP_KEY" ] && [ -f .env ]; then
    export APP_KEY=$(grep '^APP_KEY=' .env | cut -d= -f2- | tr -d '"' | tr -d "'" | head -1)
fi
if [ -z "$APP_KEY" ]; then
    echo ""
    echo "ERROR: APP_KEY is not set!"
    echo "Add it in Render: Environment -> APP_KEY"
    echo "Generate locally: php artisan key:generate --show"
    echo ""
    exit 1
fi

# Set production environment (must be exported for PHP-FPM children)
export APP_ENV=production
export APP_DEBUG=false
export LOG_CHANNEL=stderr

# Ensure storage/cache dirs are writable
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Create storage link for public files (avatars, uploads, etc.)
php artisan storage:link 2>/dev/null || true

echo "=== Connecting to PostgreSQL ==="

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
