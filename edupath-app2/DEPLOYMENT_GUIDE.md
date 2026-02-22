# EduPath Deployment Guide – Step by Step

A complete guide to connect EduPath to PostgreSQL, push to GitHub, and deploy on Render.

---

## Part 1: Local PostgreSQL Setup

### Step 1.1 – Install PostgreSQL

1. Download PostgreSQL: https://www.postgresql.org/download/windows/
2. Run the installer. During setup:
   - Set a password for the `postgres` user (remember it).
   - Keep the default port **5432**.
3. Verify installation (PowerShell):

   ```powershell
   psql -U postgres -c "SELECT version();"
   ```

### Step 1.2 – Create the Database

1. Open **pgAdmin** or connect via terminal:

   ```powershell
   psql -U postgres
   ```

2. Create the database:

   ```sql
   CREATE DATABASE edupath_db;
   \q
   ```

### Step 1.3 – Configure Your Laravel App

1. Go to your project folder:

   ```powershell
   cd c:\Users\Admin\edupath-app\edupath-app2
   ```

2. Copy the example env file (if you don't have `.env`):

   ```powershell
   copy .env.example .env
   ```

3. Edit `.env` and set the database values:

   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=edupath_db
   DB_USERNAME=postgres
   DB_PASSWORD=your_postgres_password
   ```

4. Generate the application key:

   ```powershell
   php artisan key:generate
   ```

5. Run migrations:

   ```powershell
   php artisan migrate
   ```

6. Start the app:

   ```powershell
   php artisan serve
   ```

7. Open http://127.0.0.1:8000 – you should see the app without debug output.

---

## Part 2: Push to GitHub

### Step 2.1 – Create a GitHub Repository

1. Go to https://github.com and log in.
2. Click **New repository**.
3. Choose a name (e.g. `edupath-app`).
4. Do **not** add a README or .gitignore (we already have them).
5. Click **Create repository**.

### Step 2.2 – Connect Your Code

**Option A – EduPath is inside the main repo (`edupath-app`)**

```powershell
cd c:\Users\Admin\edupath-app
git add .
git status
git commit -m "Add EduPath app with PostgreSQL and Render config"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO.git
git push -u origin main
```

**Option B – EduPath is its own repo**

```powershell
cd c:\Users\Admin\edupath-app\edupath-app2
git init
git add .
git status
git commit -m "Initial commit: EduPath Laravel app"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO.git
git push -u origin main
```

Replace `YOUR_USERNAME` and `YOUR_REPO` with your GitHub username and repo name.

### Step 2.3 – Ensure Sensitive Files Are Ignored

Your `.gitignore` should ignore:

- `.env` (never commit this)
- `node_modules/`
- `vendor/` (optional, Render will run `composer install`)

Check with:

```powershell
git status
```

`.env` must not appear in the list.

---

## Part 3: Deploy on Render

### Step 3.1 – Render Account

1. Sign up at https://render.com (free tier).
2. Connect your GitHub account (Settings → Account → Integrations).

### Step 3.2 – Create a PostgreSQL Database on Render (required)

1. In Render dashboard, click **New +** → **PostgreSQL**.
2. Configure:
   - **Name**: `edupath-db`
   - **Region**: choose one (e.g. Oregon).
   - **Plan**: Free (or paid if needed).
3. Click **Create Database**.
4. Wait until the status is **Available**.
5. Open the database → **Info** or **Connect**.
6. Copy the **Internal Database URL** (starts with `postgres://`).  
   - Use **Internal** URL (not External) so your app connects over Render’s private network.

### Step 3.3 – Create the Web Service

1. Click **New +** → **Web Service**.
2. Connect the GitHub repo that contains EduPath.
3. Settings:

| Field | Value |
|-------|-------|
| **Name** | `edupath-app` |
| **Region** | Same as the database |
| **Branch** | `main` |
| **Root Directory** | `edupath-app2` (if EduPath is in that subfolder; otherwise leave blank) |
| **Runtime** | **Docker** |
| **Instance Type** | Free |

4. Open **Environment** and add:

| Key | Value |
|-----|-------|
| `APP_KEY` | **Required.** Run `php artisan key:generate --show` and paste the output |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | Leave empty for now |
| `DATABASE_URL` | **Required.** Paste the **Internal Database URL** from Step 3.2. Without this, the app will fail with "Connection refused". |
| `DB_CONNECTION` | `pgsql` |
| `LOG_CHANNEL` | `stderr` |

5. Build & Deploy:

| Field | Value |
|-------|-------|
| **Build Command** | *(leave empty)* |
| **Start Command** | `/bin/bash /var/www/html/render-start.sh` |

6. Click **Create Web Service**.

### Step 3.4 – Set APP_URL After First Deploy

1. Wait for the first deployment to finish.
2. Open your service → **Settings**.
3. Copy the service URL (e.g. `https://edupath-app.onrender.com`).
4. Go to **Environment** → add or edit:
   - `APP_URL` = your service URL (e.g. `https://edupath-app.onrender.com`).
5. Go to **Deployments** → **Manual Deploy** → **Deploy latest commit**.

---

## Part 4: Verify Everything

1. **Local**: `http://127.0.0.1:8000` – no debug text, app works.
2. **GitHub**: Your repo has the latest code.
3. **Render**: `https://your-service.onrender.com` – app loads and connects to the database.

---

## Troubleshooting

### If you see "No application encryption key has been specified" on Render

Add `APP_KEY` in Render: Web Service → **Environment** → Add `APP_KEY` = (run `php artisan key:generate --show` locally and paste the output, e.g. `base64:xxxx...`). Then redeploy.

### If you see "DATABASE_URL: NOT SET" or "Connection refused to 127.0.0.1" on Render

1. Create a PostgreSQL database on Render (Dashboard → **New +** → **PostgreSQL**).
2. Open your **Web Service** → **Environment**.
3. Add: `DATABASE_URL` = (paste the **Internal Database URL** from your PostgreSQL service).
4. Or: Web Service → **Connect** → select your PostgreSQL service so Render adds it automatically.
5. Redeploy the Web Service (Deployments → **Manual Deploy**).

---

| Issue | What to check |
|-------|----------------|
| **DATABASE_URL NOT SET / Connection refused to 127.0.0.1** | Add `DATABASE_URL` in Render: Web Service → **Environment** → Add `DATABASE_URL` = (Internal Database URL from your PostgreSQL service). Or link the database: Web Service → **Connect** → select your PostgreSQL. Then redeploy. |
| Debug text on page | Push latest code (with debug config files removed) and redeploy on Render. |
| "Could not find driver" | Install PHP `pdo_pgsql` extension (or enable it in `php.ini`) |
| Connection refused on Render | Use the **Internal Database URL**, not the External one |
| 500 error on Render | Set `APP_DEBUG=true`, redeploy, check **Logs** for the error |
| Slow first load | Free tier spins down; first request may take 30–60 seconds |

---

## Summary

| Step | Action |
|------|--------|
| 1 | Install PostgreSQL and create `edupath_db` |
| 2 | Configure `.env` with `DB_*` for local PostgreSQL |
| 3 | Run `php artisan migrate` and `php artisan serve` |
| 4 | Create GitHub repo and push your code |
| 5 | Create PostgreSQL and Web Service on Render |
| 6 | Set `DATABASE_URL` and other env vars |
| 7 | Set `APP_URL` after first deploy and redeploy |
