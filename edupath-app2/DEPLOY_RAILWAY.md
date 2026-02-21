# Deploy EduPath to Railway

This guide walks you through deploying the Laravel app (with PostgreSQL) to [Railway](https://railway.app).

---

## Prerequisites

1. **GitHub account** – Railway deploys from a Git repository.
2. **Railway account** – Sign up at [railway.app](https://railway.app).
3. **Code on GitHub** – Push your `edupath-app2` (or `edupath-app`) project to a GitHub repo.
   - If the repo is the whole workspace, deploy the **root** and set **Root Directory** to `edupath-app2` in Railway (see step 5).
   - Or create a repo that contains only the Laravel app (e.g. only the `edupath-app2` folder contents).

---

## Step 1: Create a new project on Railway

1. Go to [railway.app](https://railway.app) and log in.
2. Click **New Project**.
3. Choose **Deploy from GitHub repo**.
4. Select your repository and (if asked) the branch (e.g. `main`).
5. If your Laravel app is in a subfolder (e.g. `edupath-app2`):
   - After adding the repo, open the new **service** → **Settings** → **Source**.
   - Set **Root Directory** to `edupath-app2` and save.

---

## Step 2: Add PostgreSQL

1. On the **Project** canvas, click **+ New** (or **Add Service**).
2. Select **Database** → **PostgreSQL**.
3. Railway will create a Postgres service and expose a `DATABASE_URL` (and often `PGHOST`, `PGUSER`, etc.).
4. Wait until the database service is **Deployed**.

---

## Step 3: Configure the Laravel service (web app)

1. Click on your **Laravel / web service** (the one from GitHub), not the database.
2. Go to **Settings** (or **Variables** first to add env vars; see Step 4).

**Build**

- **Custom Build Command** (if available): set to  
  `npm run build`  
  so Vite assets are built.

**Deploy**

- **Pre-Deploy Command**: set to  
  `chmod +x ./railway/init-app.sh && sh ./railway/init-app.sh`  
  so migrations and caches run before each deploy.

**Networking**

- In **Networking** (or **Settings** → **Networking**), click **Generate Domain** so your app gets a public URL (e.g. `yourapp.up.railway.app`).

---

## Step 4: Set environment variables

1. Open your **web service** (Laravel app).
2. Go to **Variables** (or **Variables** tab).
3. Click **Raw Editor** (or add variables one by one) and set at least:

**Required**

| Variable | Value |
|----------|--------|
| `APP_KEY` | Run `php artisan key:generate --show` locally and paste the key, or use a 32-character random string. |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | Your Railway app URL, e.g. `https://yourapp.up.railway.app` (update after you generate the domain). |

**Database (use Railway’s Postgres)**

Either use the single URL (recommended):

| Variable | Value |
|----------|--------|
| `DB_CONNECTION` | `pgsql` |
| `DB_URL` | `${{Postgres.DATABASE_URL}}` |

Or, if you prefer separate variables, use the Postgres service’s variables (Railway shows `PGHOST`, `PGPORT`, `PGUSER`, `PGPASSWORD`, `PGDATABASE`):

| Variable | Value |
|----------|--------|
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | `${{Postgres.PGHOST}}` |
| `DB_PORT` | `${{Postgres.PGPORT}}` |
| `DB_DATABASE` | `${{Postgres.PGDATABASE}}` |
| `DB_USERNAME` | `${{Postgres.PGUSER}}` |
| `DB_PASSWORD` | `${{Postgres.PGPASSWORD}}` |

Replace `Postgres` with the **exact name** of your Postgres service in Railway if it’s different.

**Logging (recommended on Railway)**

| Variable | Value |
|----------|--------|
| `LOG_CHANNEL` | `stderr` |

**Optional (copy from your local `.env` if you use them)**

- `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`
- `QUEUE_CONNECTION` = `database` if you use queues

---

## Step 5: Deploy

1. Save all settings and variables.
2. Trigger a deploy:
   - **Redeploy** from the **Deployments** tab, or
   - Push a new commit to the connected branch; Railway will redeploy automatically.
3. After the build finishes, open the **generated domain** (e.g. `https://yourapp.up.railway.app`). You should see your Laravel app.
4. If something fails, check **Deployments** → latest deployment → **View logs**.

---

## Step 6: Run migrations manually (if needed)

If you didn’t use the Pre-Deploy script or migrations failed:

1. Install [Railway CLI](https://docs.railway.com/cli):  
   `npm i -g @railway/cli`  
   or see the official install instructions.
2. Log in: `railway login`.
3. In your project directory (Laravel app root):  
   `railway link`  
   and select the project and the **web service** (not the database).
4. Run:  
   `railway run php artisan migrate --force`  
   Migrations will run against the Railway Postgres database.

---

## Checklist

- [ ] Repo on GitHub (and optionally Root Directory = `edupath-app2`).
- [ ] New Railway project → Deploy from GitHub.
- [ ] PostgreSQL service added.
- [ ] Web service: Custom Build = `npm run build`, Pre-Deploy = `chmod +x ./railway/init-app.sh && sh ./railway/init-app.sh`.
- [ ] Variables: `APP_KEY`, `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`, `DB_CONNECTION=pgsql`, `DB_URL` (or full DB_* from Postgres), `LOG_CHANNEL=stderr`.
- [ ] Generate Domain for the web service.
- [ ] Deploy and open the app URL; run migrations via CLI if needed.

---

## Troubleshooting

- **500 error**: Check logs in Railway; often missing `APP_KEY` or wrong `APP_URL`. Ensure `APP_DEBUG=false` in production.
- **Database connection error**: Confirm `DB_URL` (or `DB_HOST`, etc.) points to the Postgres service variable (e.g. `${{Postgres.DATABASE_URL}}`) and that the Postgres service name matches.
- **Migrations not run**: Use Pre-Deploy script (Step 3) or run `railway run php artisan migrate --force` (Step 6).
- **Assets (CSS/JS) missing**: Ensure Custom Build Command is `npm run build` and that the build step succeeds in the deployment logs.
