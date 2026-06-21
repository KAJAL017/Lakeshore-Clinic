# Lakeshore Clinic - Hostinger Deployment Guide

## Overview
Deploy your Laravel 12 clinic management app to Hostinger Shared Hosting (hPanel).

## Prerequisites
- Hostinger Shared Hosting account
- MySQL database created via hPanel
- File Manager access or FTP access

---

## STEP 1: Create Database on Hostinger

1. Login to Hostinger hPanel
2. Go to **Databases** → **MySQL Databases**
3. Create a new database:
   - Database Name: `lakeshore_clinic`
   - Username: `your_chosen_username`
   - Password: `strong_password`
4. Note down:
   - Database name (usually: `u123456789_lakeshore_clinic`)
   - Database username (usually: `u123456789_your_username`)
   - Database password
   - Database host: `localhost`

---

## STEP 2: Prepare Deployment Package

### Option A: Manual ZIP (Recommended)

1. **On your local machine, run this to create deployment ZIP:**
   ```bash
   # In the project root directory, run:
   npm run build
   ```

2. **Create the ZIP with these folders/files:**
   - `app/` (entire folder)
   - `bootstrap/` (entire folder)
   - `config/` (entire folder)
   - `database/` (entire folder)
   - `public/` (entire folder - this goes to public_html root)
   - `resources/` (entire folder)
   - `routes/` (entire folder)
   - `storage/` (entire folder - ensure it's writable)
   - `vendor/` (entire folder)
   - `artisan` (file)
   - `composer.json` (file)
   - `composer.lock` (file)
   - `.env.production` (rename to `.env` after upload)

3. **DO NOT include:**
   - `node_modules/`
   - `.git/`
   - `tests/`
   - `*.md` files
   - `phpunit.xml`

### Option B: Using Git (if repository is on GitHub/GitLab)

```bash
# On Hostinger SSH (if available) or via terminal:
git clone YOUR_REPO_URL /home/USERNAME/laravel-app
cd /home/USERNAME/laravel-app
composer install --optimize-autoloader --no-dev
cp .env.production .env
# Edit .env with database credentials
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## STEP 3: Upload to Hostinger

### Method 1: File Manager (Easiest)

1. Login to Hostinger hPanel
2. Go to **Files** → **File Manager**
3. Navigate to `public_html/`
4. Upload the ZIP file
5. Extract the ZIP in `public_html/`

**IMPORTANT STRUCTURE:**

For Hostinger shared hosting, use this structure:

```
/home/USERNAME/
├── laravel-app/          (Laravel core - ABOVE public_html)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── artisan
│   ├── composer.json
│   ├── composer.lock
│   └── .env
│
└── public_html/          (Document Root - ONLY public files)
    ├── index.php         (Modified to point to ../laravel-app/)
    ├── .htaccess
    ├── build/            (Compiled assets)
    ├── images/
    ├── uploads/
    ├── website/
    └── favicon.ico
```

### Method 2: Upload Everything in public_html

If you prefer simplicity, upload everything to `public_html/`:

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          (Rename contents to root)
├── resources/
├── routes/
├── storage/
├── vendor/
├── artisan
├── composer.json
├── composer.lock
└── .env
```

Then modify `public_html/index.php`:
```php
<?php
define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Illuminate\Http\Request::capture());
```

---

## STEP 4: Configure .env

1. After upload, rename `.env.production` to `.env`
2. Edit `.env` with your Hostinger database credentials:

```env
APP_NAME="Lakeshore Clinic"
APP_ENV=production
APP_KEY=base64:GENERATE_NEW_KEY_HERE
APP_DEBUG=false
APP_URL=https://YOUR-SUBDOMAIN-HOSTINGER.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_lakeshore_clinic
DB_USERNAME=u123456789_your_username
DB_PASSWORD=your_database_password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

---

## STEP 5: Generate APP_KEY

Via SSH (if available):
```bash
cd /home/USERNAME/public_html
php artisan key:generate
```

Or manually generate and paste into `.env`.

---

## STEP 6: Run Migrations

Via SSH:
```bash
cd /home/USERNAME/public_html
php artisan migrate --force
```

Or via **Terminal** in hPanel if available.

---

## STEP 7: Set Permissions

Ensure these folders are writable:

```
storage/           → 755 or 775
storage/app/       → 755
storage/framework/ → 755
storage/logs/      → 755
bootstrap/cache/   → 755
```

Via File Manager: Right-click folder → Permissions → Set to 755

---

## STEP 8: Cache Configuration (Optional - Recommended)

Via SSH:
```bash
cd /home/USERNAME/public_html
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## STEP 9: Configure Document Root

In Hostinger hPanel:

1. Go to **Website** → **General Settings**
2. Set Document Root to:
   - `/public_html` (if all files are in public_html)
   - OR `/public_html/public` (if using recommended structure)

---

## Common Issues & Fixes

### 1. 500 Internal Server Error
- Check `.env` file exists and has correct database credentials
- Ensure `storage/` and `bootstrap/cache/` are writable
- Check `storage/logs/laravel.log` for errors

### 2. Assets Not Loading (CSS/JS 404)
- Ensure `public/build/` folder was uploaded
- Run `npm run build` before uploading
- Check APP_URL matches your actual domain

### 3. Database Connection Error
- Verify database credentials in `.env`
- Ensure database was created in hPanel
- Database host should be `localhost`

### 4. Routes Not Working
- Ensure `.htaccess` is in public_html
- Enable mod_rewrite in hPanel (if needed)

### 5. Upload/Storage Issues
- Ensure `storage/app/uploads/` exists and is writable
- Check filesystem permissions

### 6. Session Issues
- Ensure sessions table was migrated
- Or change SESSION_DRIVER to `file` in .env

---

## Post-Deployment Checklist

- [ ] Database created on Hostinger
- [ ] .env configured with correct credentials
- [ ] APP_KEY generated
- [ ] Migrations run successfully
- [ ] Assets built and uploaded (`public/build/`)
- [ ] Storage permissions set (755)
- [ ] Document root configured correctly
- [ ] Test login functionality
- [ ] Test file uploads
- [ ] Test appointment booking

---

## Hostinger-Specific Notes

### PHP Version
Ensure PHP 8.2+ is selected:
1. hPanel → **Website** → **PHP Configuration**
2. Select PHP 8.2 or 8.3

### SSL Certificate
1. hPanel → **SSL** → **Install SSL**
2. Use Let's Encrypt (free)
3. Enable "Force HTTPS"

### Cron Jobs (for Queue/Cache)
If using database queue:
1. hPanel → **Advanced** → **Cron Jobs**
2. Add: `* * * * * cd /home/USERNAME/public_html && php artisan schedule:run >> /dev/null 2>&1`

---

## Quick Commands (SSH)

```bash
# Navigate to project
cd /home/USERNAME/public_html

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Seed database (if needed)
php artisan db:seed --force

# Check disk space
df -h

# Check PHP version
php -v
```

---

## Support

If you encounter issues:
1. Check `storage/logs/laravel.log`
2. Enable `APP_DEBUG=true` temporarily
3. Check Hostinger error logs in hPanel
