#!/usr/bin/env bash
set -e
cd /var/www/html

echo "=== Simple Database Test ==="

# Test database connection
if php artisan db:show 2>/dev/null; then
    echo "Database connection successful!"
    php artisan db:show
else
    echo "Database connection failed!"
    echo "Trying to set DATABASE_URL directly..."
    
    if [ ! -z "$DATABASE_URL" ]; then
        echo "DATABASE_URL found: $DATABASE_URL"
        echo "DATABASE_URL=$DATABASE_URL" > .env
        echo "DB_CONNECTION=pgsql" >> .env
        echo "APP_ENV=production" >> .env
        echo "APP_DEBUG=false" >> .env
        
        echo "Testing with DATABASE_URL..."
        if php artisan db:show 2>/dev/null; then
            echo "SUCCESS: Database connected with DATABASE_URL"
            php artisan db:show
        else
            echo "FAILED: Still cannot connect with DATABASE_URL"
        fi
    else
        echo "No DATABASE_URL available"
    fi
fi
