# Render Deployment Checklist

Use this checklist when deploying EduPath to Render.

## Before Deploy

- [ ] PostgreSQL database created on Render
- [ ] APP_KEY generated (`php artisan key:generate --show`)
- [ ] Code pushed to GitHub

## Required Environment Variables (Render Web Service)

| Variable | How to Get |
|----------|------------|
| `APP_KEY` | Run `php artisan key:generate --show` locally |
| `DATABASE_URL` | From PostgreSQL service → Info → Internal Database URL |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | Your service URL (e.g. `https://yourservice.onrender.com`) |
| `DB_CONNECTION` | `pgsql` |
| `LOG_CHANNEL` | `stderr` |

## Render Web Service Settings

- **Runtime:** Docker
- **Start Command:** `/bin/bash /var/www/html/render-start.sh`
- **Root Directory:** `edupath-app2` (if app is in that subfolder)

## After First Deploy

1. Copy your service URL from Render
2. Add `APP_URL` = that URL in Environment
3. Redeploy (Manual Deploy → Deploy latest commit)
