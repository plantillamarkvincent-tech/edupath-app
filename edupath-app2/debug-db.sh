#!/usr/bin/env bash
set -e
cd /var/www/html

echo "=== Database Debug Script ==="
echo "Current working directory: $(pwd)"
echo "Environment variables available:"
env | grep -E "(DATABASE|DB_)" | sort || echo "No database variables found"

echo "=== .env file contents ==="
if [ -f .env ]; then
    cat .env | grep -E "(DATABASE|DB_)" | sort || echo "No database settings in .env"
else
    echo ".env file not found"
fi

echo "=== Laravel config test ==="
php artisan tinker --execute="echo config('database.default'); echo config('database.connections.pgsql.host'); echo config('database.connections.pgsql.port'); echo config('database.connections.pgsql.database');"
