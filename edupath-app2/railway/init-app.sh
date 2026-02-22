#!/bin/sh
# Pre-Deploy: migrations and caches. Do not use set -e so one failure doesn't kill the deploy.
php artisan migrate --force --no-interaction 2>/dev/null || true
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true
php artisan storage:link 2>/dev/null || true
exit 0
