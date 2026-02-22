# Deploy EduPath to Render (Frontend + Backend + Database)

Step-by-step guide to deploy your Laravel app with PostgreSQL on [Render](https://render.com). Frontend (Vite), backend (Laravel), and database (PostgreSQL) all work together.

---

## What you need first

1. **GitHub account** – Render deploys from a Git repo.
2. **Render account** – Sign up at [render.com](https://render.com) (free tier available).
3. **Code on GitHub** – Your `edupath-app2` (or Laravel app) pushed to a GitHub repo.

---

## Part 1: On your computer

### 1.1 – Open the Laravel app folder

```bash
cd c:\Users\Admin\edupath-app\edupath-app2
```

### 1.2 – Generate an app key (for production)

```bash
php artisan key:generate --show
```

**Copy the output** (e.g. `base64:xxxx...`). You will paste it in Render as `APP_KEY`.

### 1.3 – Push your code to GitHub

If the repo is the **parent** folder (`edupath-app`):

```bash
cd c:\Users\Admin\edupath-app
git add .
git commit -m "Add Render deployment files"
git push origin main
```

If your **Laravel app is its own repo**:

```bash
cd c:\Users\Admin\edupath-app\edupath-app2
git add .
git commit -m "Add Render deployment files"
git push origin main
```

Make sure these files are in the repo: `Dockerfile`, `.dockerignore`, `render-start.sh`, and your Laravel code.

---

## Part 2: On Render – Create PostgreSQL database

1. Go to [dashboard.render.com](https://dashboard.render.com).
2. Click **New +** → **PostgreSQL**.
3. Choose a **name** (e.g. `edupath-db`) and **region** (closest to you).
4. Select **Free** (or a paid plan).
5. Click **Create Database**.
6. Wait until the status is **Available**.
7. Open the database → **Connect** (or **Info**). Copy the **Internal Database URL** (starts with `postgres://`). You will use it as `DATABASE_URL` for the web service.

**Why:** The app will connect to this database. Internal URL is used so traffic stays on Render’s network.

---

## Part 3: On Render – Create Web Service (Laravel app)

1. Click **New +** → **Web Service**.
2. Connect your **GitHub** account if asked, then select the **repository** that contains your Laravel app.
3. Configure the service:

| Field | Value |
|--------|--------|
| **Name** | e.g. `edupath-app` |
| **Region** | Same as the database (e.g. Oregon). |
| **Branch** | `main` (or your default branch). |
| **Root Directory** | Leave **empty** if the repo root is the Laravel app. If the Laravel app is in a subfolder (e.g. `edupath-app2`), set **Root Directory** to `edupath-app2`. |
| **Runtime** | **Docker**. |
| **Instance Type** | **Free** (or a paid plan). |

4. Click **Advanced** and add **Environment Variables**:

| Key | Value |
|-----|--------|
| `APP_KEY` | Paste the key from step 1.2. |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | Leave empty for now; you’ll set it after the first deploy (e.g. `https://edupath-app.onrender.com`). |
| `DATABASE_URL` | Paste the **Internal Database URL** from your Render Postgres (Part 2, step 7). |
| `DB_CONNECTION` | `pgsql` |
| `LOG_CHANNEL` | `stderr` |

Optional (if you use mail): `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`.

5. **Build & Deploy:**

| Field | Value |
|--------|--------|
| **Build Command** | Leave **empty** (the Dockerfile runs the build). |
| **Start Command** | `/bin/bash /var/www/html/render-start.sh` |

This runs migrations and caches, then starts the web server.

6. Click **Create Web Service**. Render will build the Docker image and deploy. The first build can take several minutes.

7. After the first deploy, open your service → **Settings** → copy the **URL** (e.g. `https://edupath-app.onrender.com`). Go to **Environment** and add or update:

   - `APP_URL` = that URL (e.g. `https://edupath-app.onrender.com`).

8. **Redeploy** (Deployments → **Manual Deploy** → **Deploy latest commit**) so the app uses the correct `APP_URL`.

---

## Part 4: Check that it works

1. Open your app URL (e.g. `https://edupath-app.onrender.com`). You should see your Laravel app (frontend + backend).
2. Try logging in or submitting a form; that uses the database.

If you see **500** or a blank page:

- Open **Logs** for the Web Service and look for PHP or database errors.
- Confirm `APP_KEY` and `DATABASE_URL` are set and that `DATABASE_URL` is the **Internal** URL from the Render Postgres service.

---

## Summary: what runs where

| Part | Where |
|------|--------|
| **Frontend** | Built inside the Docker image (`npm run build` in the Dockerfile). Served by the same Web Service. |
| **Backend** | Laravel (PHP) runs in the same container; `render-start.sh` runs migrations and caches, then starts nginx/PHP-FPM. |
| **Database** | Render PostgreSQL; the app connects via `DATABASE_URL`. |

One **Web Service** (Docker) + one **PostgreSQL** service. After you set variables and deploy, they work together automatically.

---

## Commands you used (reference)

| Step | Command / action |
|------|-------------------|
| 1.2 | `php artisan key:generate --show` |
| 1.3 | `git add .` → `git commit -m "..."` → `git push origin main` |
| 2 | Render: New → PostgreSQL → create → copy Internal Database URL |
| 3 | Render: New → Web Service → connect repo → Runtime: **Docker** → Root Directory (if needed) → Environment: APP_KEY, APP_ENV, APP_DEBUG, APP_URL, DATABASE_URL, DB_CONNECTION, LOG_CHANNEL → Start Command: `/bin/bash /var/www/html/render-start.sh` → Create Web Service |
| 4 | Set APP_URL to the service URL → Redeploy |

---

## Troubleshooting

- **Build fails (e.g. composer or npm):** Check the **Build logs** on Render. Ensure `Dockerfile`, `render-start.sh`, and `package.json` / `composer.json` are in the repo (and in the Root Directory if you set one).
- **“Could not find driver” (database):** The PHP image may lack the PostgreSQL driver. Share the exact error; we can switch to a PHP image that includes `pdo_pgsql` or add it in the Dockerfile.
- **Free tier:** The Web Service may **spin down** after ~15 minutes of no traffic. The first request after that can take 30–60 seconds to respond; later requests are fast.
- **500 or blank page:** Set `APP_DEBUG=true` temporarily, redeploy, and check **Logs** for the error. Fix the cause (e.g. missing `APP_KEY` or wrong `DATABASE_URL`), then set `APP_DEBUG=false` again.
- **Assets (CSS/JS) missing:** The Dockerfile runs `npm run build`; confirm the build step succeeds in the Render build logs.
