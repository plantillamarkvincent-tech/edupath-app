#!/usr/bin/env bash
set -e
cd /var/www/html

echo "=== Starting Laravel Application on Render ==="

# CRITICAL: Render must provide DATABASE_URL (Internal Database URL from your PostgreSQL service)
if [ -z "$DATABASE_URL" ]; then
    echo ""
    echo "ERROR: DATABASE_URL is not set!"
    echo ""
    echo "To fix this on Render:"
    echo "1. Create a PostgreSQL database: Dashboard -> New + -> PostgreSQL"
    echo "2. Open your Web Service -> Environment"
    echo "3. Add: DATABASE_URL = (paste Internal Database URL from your PostgreSQL service)"
    echo "4. Or: Link the database to this service (Connect -> select your PostgreSQL)"
    echo ""
    exit 1
fi

# Copy production environment configuration
if [ -f env-production ]; then
    cp env-production .env
fi

# Set production environment
export APP_ENV=production
export APP_DEBUG=false

echo "=== Database: DATABASE_URL is set, connecting to Render PostgreSQL ==="

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
