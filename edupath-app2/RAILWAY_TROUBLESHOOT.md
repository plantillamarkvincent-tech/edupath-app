# Railway deploy not working – what to check

When you say "I can't deploy", the fix depends on **where** it fails. Use this checklist and share the **exact error** from Railway (Build or Deploy logs).

---

## 1. Where is it failing?

In Railway, open your **app service** → **Deployments** → click the **latest deployment** → **View logs**.

- **Build failed** → See section A below.
- **Deploy / Pre-Deploy failed** → See section B.
- **App starts then crashes or 503** → See section C.
- **You never get a URL / "No deployments"** → See section D.

---

## 2. A – Build failed

**Typical errors:**

| Error | What to do |
|------|------------|
| `collision between yarn/LICENSE and composer/LICENSE` or `nix-env failed` | The repo now has `nixpacks.toml` to avoid this. Commit and push: `git add nixpacks.toml railway/ && git commit -m "Fix Railway build" && git push`. Then redeploy. |
| `No version available for php 8.0` / `php 8.1` | Your `composer.json` already has `"php": "^8.2"`. If the error persists, in Railway **Variables** add: `NIXPACKS_PHP_VERSION=8.2`. |
| `npm ERR!` or `composer install` fails | In the build log, copy the **full** error. Often it’s a missing `package-lock.json` or a PHP extension. We can fix once you share it. |
| `Root Directory` / "No composer.json" | In Railway → your service → **Settings** → **Source** → set **Root Directory** to `edupath-app2` (if your repo root is the parent of the Laravel app). |

**Commands to run locally and push:**

```bash
cd c:\Users\Admin\edupath-app\edupath-app2
git add nixpacks.toml railway/
git status
git commit -m "Fix Railway build and pre-deploy"
git push origin main
```

Then in Railway click **Redeploy**.

---

## 3. B – Deploy / Pre-Deploy failed

**Typical cause:** Pre-Deploy runs `railway/init-app.sh`. If the app has no `APP_KEY` or database URL yet, `php artisan config:cache` or `migrate` can fail.

**What to do:**

1. In Railway → **Variables**, make sure you have:
   - `APP_KEY` (from `php artisan key:generate --show`)
   - `DB_CONNECTION=pgsql`
   - `DB_URL=${{Postgres.DATABASE_URL}}` (or your Postgres service name instead of `Postgres`)
2. Add Postgres if you haven’t: **+ New** → **Database** → **PostgreSQL**.
3. Save variables, then **Redeploy**.

If you prefer to **skip** Pre-Deploy until the app is up:

- **Settings** → **Deploy** → clear **Pre-Deploy Command** (leave it empty), save, redeploy.
- After the app is live, run migrations once via Railway CLI: `railway run php artisan migrate --force`, then turn Pre-Deploy back on.

---

## 4. C – App starts then crashes or 503

**What to do:**

1. **Variables:** Set `APP_DEBUG=false`, `APP_ENV=production`, and `LOG_CHANNEL=stderr` so errors show in Railway logs.
2. **Networking:** Your app service must have a **Generated Domain** (Settings → Networking → Generate Domain).
3. In **Deployments** → **View logs**, check the **runtime** logs (after “Build succeeded”) for PHP errors or “Connection refused” (database). Fix missing variables (e.g. `APP_KEY`, `DB_URL`) and redeploy.

---

## 5. D – No public URL / “Nothing to deploy”

- **Generate Domain:** App service → **Settings** → **Networking** → **Generate Domain**.
- **Repo connection:** Settings → **Source** → confirm the correct repo and branch (e.g. `main`) and **Root Directory** (`edupath-app2` if needed). Push a commit and wait for the deploy to start.

---

## 6. Quick checklist (copy and fill)

Use this and, if it still fails, send the **exact error line** from the logs.

- [ ] Code pushed to GitHub (including `edupath-app2` and, if used, `nixpacks.toml` + `railway/init-app.sh`).
- [ ] Railway project created from that repo; **Root Directory** = `edupath-app2` if the repo root is not the Laravel app.
- [ ] PostgreSQL added as a separate service; app service has **Variables**: `APP_KEY`, `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://...`, `DB_CONNECTION=pgsql`, `DB_URL=${{Postgres.DATABASE_URL}}`, `LOG_CHANNEL=stderr`.
- [ ] **Build:** Custom Build Command = `npm run build` (or leave empty if using `nixpacks.toml`).
- [ ] **Pre-Deploy:** `chmod +x ./railway/init-app.sh && sh ./railway/init-app.sh` (or empty to skip for first deploy).
- [ ] **Networking:** Generate Domain done; `APP_URL` in Variables = that URL.
- [ ] **Redeploy** after any change to Variables or Settings.

---

**To help you precisely:** Copy the **exact error message** (and whether it’s from **Build** or **Deploy** / runtime logs) and paste it here. Then we can target the fix.
