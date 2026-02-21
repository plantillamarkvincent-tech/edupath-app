#!/bin/sh
set -e
# Run migrations and caches on Railway (Pre-Deploy)
php artisan migrate --force --no-interaction || true
php artisan config:cache
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true
php artisan storage:link 2>/dev/null || true
exit 0
