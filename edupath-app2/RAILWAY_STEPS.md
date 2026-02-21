# Step-by-Step: Deploy EduPath (Frontend + Backend + Database) on Railway

Follow these steps in order. Each step tells you **what to do** and **why**, so you learn how deployment works.

---

## Part 1: Prepare your code (on your computer)

### Step 1.1 – Open terminal in your project

```bash
cd c:\Users\Admin\edupath-app\edupath-app2
```

**Why:** All commands below run from the Laravel app folder.

---

### Step 1.2 – Generate an app key for production

```bash
php artisan key:generate --show
```

**Copy the output** (e.g. `base64:xxxxx...`). You will paste it into Railway later as `APP_KEY`.

**Why:** Laravel needs a secret key to encrypt sessions and data. Production must have its own key.

---

### Step 1.3 – Put your app on GitHub

**Option A – Your repo is the whole `edupath-app` folder (parent):**

1. Go to the **parent** folder and push:
   ```bash
   cd c:\Users\Admin\edupath-app
   git add .
   git commit -m "Prepare for Railway deploy"
   git push origin main
   ```
2. Later on Railway you will set **Root Directory** to `edupath-app2` so Railway uses only the Laravel app.

**Option B – You want a repo that contains only the Laravel app:**

1. Create a **new empty repo** on GitHub (e.g. `edupath-laravel`).
2. In your Laravel app folder:
   ```bash
   cd c:\Users\Admin\edupath-app\edupath-app2
   git init
   git add .
   git commit -m "Initial commit for Railway"
   git branch -M main
   git remote add origin https://github.com/YOUR_USERNAME/edupath-laravel.git
   git push -u origin main
   ```
   Replace `YOUR_USERNAME` and `edupath-laravel` with your GitHub username and repo name.

**Why:** Railway builds and runs your app by cloning your GitHub repo. No GitHub = no deploy.

---

## Part 2: Create the project on Railway

### Step 2.1 – Create a new project

1. Go to **https://railway.app** and sign in (use GitHub if you can).
2. Click **New Project**.
3. Choose **Deploy from GitHub repo**.
4. Select the repository you pushed in Step 1.3 (and the branch, usually `main`).
5. Click **Deploy** (or continue). Railway will create one **service** (your app).

**Why:** One “project” can have several “services” (e.g. one for the app, one for the database). You start with the app service.

---

### Step 2.2 – Set the root directory (only if Laravel is in a subfolder)

If your GitHub repo is the whole workspace (e.g. `edupath-app` with `edupath-app2` inside):

1. Click your **app service** (the one from GitHub).
2. Go to **Settings** → **Source** (or **Build**).
3. Find **Root Directory** and set it to: `edupath-app2`
4. Save.

**Why:** Railway must run and build from the folder that has `composer.json` and `artisan` (the Laravel app).

---

### Step 2.3 – Add the database (PostgreSQL)

1. On the project page, click **+ New** (or **Add Service**).
2. Choose **Database** → **PostgreSQL**.
3. Wait until the new service shows **Deployed** (or “Active”).

**Why:** Your app needs a database. Railway will create a Postgres instance and give you a connection URL. No need to install or host Postgres yourself.

---

### Step 2.4 – Connect the app to the database (variables)

1. Click your **app service** (the web app), not the Postgres service.
2. Open the **Variables** tab.
3. Click **Raw Editor** (or “Add variable” and add each line below).

Add these (replace placeholders where noted):

```env
APP_KEY=paste_the_key_from_step_1.2_here
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app
DB_CONNECTION=pgsql
DB_URL=${{Postgres.DATABASE_URL}}
LOG_CHANNEL=stderr
```

- **APP_URL:** Leave a placeholder for now; you’ll set it after generating the domain (Step 2.6).
- **DB_URL:** Use exactly `${{Postgres.DATABASE_URL}}`. If your Postgres service has a different name (e.g. “Postgresql”), change it to `${{Postgresql.DATABASE_URL}}` (check the name in the left sidebar).

**Why:** The app runs with these env vars. `DB_URL` tells Laravel how to connect to Railway’s Postgres so backend and database work together automatically.

---

### Step 2.5 – Tell Railway how to build and run the app

1. Still in your **app service** → **Settings**.
2. **Build:**
   - Find **Custom Build Command** (or “Build Command”).
   - Set it to: `npm run build`
   - **Why:** This builds your frontend (Vite/JS/CSS) so the deployed site has assets.
3. **Deploy:**
   - Find **Pre-Deploy Command** (or “Pre-deploy”).
   - Set it to: `chmod +x ./railway/init-app.sh && sh ./railway/init-app.sh`
   - **Why:** Before each deploy this runs migrations and caches so the database schema is up to date and the app is optimized.

Save if there’s a Save button.

---

### Step 2.6 – Get a public URL (frontend + backend together)

1. In your **app service**, open **Settings** → **Networking** (or the **Networking** tab).
2. Click **Generate Domain**.
3. Copy the URL (e.g. `https://edupath-app-production-xxxx.up.railway.app`).
4. Go back to **Variables** and set **APP_URL** to this URL (with `https://`).

**Why:** One URL serves your Laravel app: backend (PHP) and frontend (HTML/JS/CSS). Railway runs PHP and serves the built assets from the same service.

---

### Step 2.7 – Redeploy so everything runs

1. Open the **Deployments** tab of your app service.
2. Click **Redeploy** on the latest deployment (or push a new commit to trigger a deploy).

After the build finishes:

- **Build:** installs PHP dependencies and runs `npm run build` (frontend).
- **Pre-Deploy:** runs `railway/init-app.sh` (migrations + cache).
- **Start:** Railway runs your Laravel app (backend) and serves it on the generated URL.

**Why:** First deploy might have been without variables or domain. Redeploy applies all settings so frontend, backend, and database work together automatically.

---

## Part 3: Check that everything works

1. Open your **APP_URL** in the browser (e.g. `https://yourapp.up.railway.app`).
2. You should see your Laravel app (frontend).
3. Try logging in or submitting a form; that uses the backend and database.

If something fails:

- Check **Deployments** → latest deploy → **View logs**.
- Confirm **Variables** has the correct `APP_KEY`, `APP_URL`, and `DB_URL` (and that the Postgres service name in `${{Postgres.DATABASE_URL}}` is correct).

---

## Summary: what runs where

| Part        | Where it runs        | How it’s set up                                      |
|------------|----------------------|------------------------------------------------------|
| **Frontend** | Same service as app  | `npm run build` in Build step → assets in `public/build` |
| **Backend**  | Same service as app  | Railway runs PHP/Laravel; one public URL             |
| **Database** | Postgres service     | Added in Step 2.3; app connects via `DB_URL`         |

So: **one app service** (frontend + backend) + **one Postgres service** (database), and they work together automatically after you set variables and redeploy.

---

## Commands you used (for your reference)

| Step   | Command / action |
|--------|-------------------|
| 1.2    | `php artisan key:generate --show` |
| 1.3    | `git add .` → `git commit -m "..."` → `git push origin main` |
| 2.3    | In Railway: + New → Database → PostgreSQL |
| 2.4    | Variables: APP_KEY, APP_ENV, APP_DEBUG, APP_URL, DB_CONNECTION, DB_URL, LOG_CHANNEL |
| 2.5    | Build: `npm run build`; Pre-Deploy: `chmod +x ./railway/init-app.sh && sh ./railway/init-app.sh` |
| 2.6    | Networking → Generate Domain; set APP_URL to that URL |
| 2.7    | Redeploy |

Once this works, every new **git push** to the connected branch will trigger a new deploy (frontend built again, migrations run again, backend restarted) so the app keeps updating automatically.
