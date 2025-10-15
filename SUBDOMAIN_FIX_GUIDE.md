# Subdomain Fix Guide - OSR Digital

## 🚨 Current Issue
The subdomain [https://osr.codebundles.com/](https://osr.codebundles.com/) is showing a directory listing instead of the Laravel application.

## 🔧 Quick Fix Steps

### Step 1: Test PHP Functionality
1. Visit: `https://osr.codebundles.com/test.php`
2. This will show you what's working and what's not
3. Look for any error messages

### Step 2: Check Document Root
The document root should point to the main application folder (not the `public` folder).

**Current Setup Needed:**
```
Document Root: /path/to/osr.codebundles.com/
├── index.php          ← Should be here
├── .htaccess          ← Should be here
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── vendor/
└── .env
```

### Step 3: Verify Files Exist
Make sure these files are in the root directory:
- ✅ `index.php` (Laravel entry point)
- ✅ `.htaccess` (Apache configuration)
- ✅ `vendor/` directory (Composer dependencies)
- ✅ `bootstrap/` directory (Laravel bootstrap)

### Step 4: Check Server Configuration

#### Option A: Root Directory Setup (Recommended)
1. **Document Root**: Point to `/path/to/osr.codebundles.com/`
2. **Ensure**: `index.php` and `.htaccess` are in the root
3. **Check**: PHP is enabled and processing `.htaccess`

#### Option B: Public Folder Setup
1. **Document Root**: Point to `/path/to/osr.codebundles.com/public/`
2. **Ensure**: `public/index.php` and `public/.htaccess` exist
3. **Check**: PHP is enabled and processing `.htaccess`

### Step 5: Fix .htaccess Issues

If the `.htaccess` file is not working, try this minimal version:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
```

### Step 6: Check PHP Configuration

Ensure these PHP settings are enabled:
- `mod_rewrite` module
- `allow_url_fopen`
- `file_get_contents`
- PHP 8.1+ version

### Step 7: Test Laravel Application

If PHP is working, test the Laravel application:

1. **Check if index.php works:**
   ```bash
   php index.php
   ```

2. **Check Laravel configuration:**
   ```bash
   php artisan --version
   ```

3. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

### Step 8: Common Issues & Solutions

#### Issue: Directory Listing Still Shows
**Solution:**
- Check if `mod_rewrite` is enabled
- Verify document root is correct
- Ensure `.htaccess` file is in the right location
- Check file permissions (755 for directories, 644 for files)

#### Issue: 500 Internal Server Error
**Solution:**
- Check PHP error logs
- Verify file permissions
- Ensure all required PHP extensions are installed
- Check if `.env` file exists and is configured

#### Issue: Assets Not Loading
**Solution:**
- Verify `public/build/` directory exists
- Check if `npm run build` was executed
- Ensure `ASSET_URL` is set in `.env`

### Step 9: Environment Configuration

Create a `.env` file in the root directory:

```env
APP_NAME="OSR Digital"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://osr.codebundles.com
ASSET_URL=https://osr.codebundles.com/public

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### Step 10: Deploy Laravel Application

Run these commands on the server:

```bash
# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed --force

# Create storage link
php artisan storage:link

# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🎯 Expected Result

After fixing these issues, you should see:
- ✅ Homepage loads at `https://osr.codebundles.com/`
- ✅ Admin panel accessible at `/admin`
- ✅ No directory listing
- ✅ Assets load correctly

## 🆘 If Still Not Working

1. **Check server error logs** for specific error messages
2. **Contact your hosting provider** to ensure:
   - `mod_rewrite` is enabled
   - PHP 8.1+ is available
   - Document root is configured correctly
3. **Try the public folder setup** as an alternative
4. **Check file permissions** on all directories and files

## 📞 Support

If you need help:
1. Check the test.php file results
2. Review server error logs
3. Verify hosting provider settings
4. Check Laravel logs in `storage/logs/`

---

**The main issue is that the server is not executing the Laravel application properly. Once you fix the document root and ensure the `.htaccess` file is processed, the website should work!** 🚀
