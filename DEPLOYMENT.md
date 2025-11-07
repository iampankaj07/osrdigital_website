# Shared Hosting Deployment Guide

This guide will help you deploy the OSR Digital application to shared hosting.

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm (for building assets)
- MySQL/MariaDB database
- SSH access (recommended) or FTP/SFTP

## Pre-Deployment Checklist

### 1. Build Assets for Production

```bash
# Install dependencies
npm install

# Build production assets
npm run build
```

### 2. Optimize Composer for Production

```bash
# Install production dependencies only (no dev dependencies)
composer install --no-dev --optimize-autoloader

# Or if already installed, remove dev dependencies
composer install --no-dev --optimize-autoloader --no-interaction
```

### 3. Prepare Environment File

1. Copy `.env.example` to `.env` (if not exists)
2. Configure the following in `.env`:

```env
APP_NAME="OSR Digital"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Hosting Configuration
HOSTING_ENV=shared
ASSET_URL=

# Session & Cache (use database for shared hosting)
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# File Storage
FILESYSTEM_DISK=local
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

## Deployment Steps

### Option 1: Standard Laravel Structure (Recommended)

If your hosting allows you to set the document root to the `public` folder:

1. **Upload all files** to your hosting directory
2. **Set document root** to the `public` folder in your hosting control panel
3. **Set permissions**:
   ```bash
   chmod -R 755 storage bootstrap/cache
   chmod -R 755 public
   ```
4. **Set up storage**:
   ```bash
   # For shared hosting (no symlinks)
   php artisan storage:setup-no-symlink --copy
   # OR for servers with symlink support
   php artisan storage:link
   ```
5. **Run migrations**:
   ```bash
   php artisan migrate --force
   ```
6. **Optimize for production**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan event:cache
   ```

### Option 2: Root Directory Setup (Shared Hosting)

If you cannot change the document root and must use the root directory:

1. **Upload all files** to your hosting directory
2. The root `index.php` and `.htaccess` will handle routing
3. **Set permissions**:
   ```bash
   chmod -R 755 storage bootstrap/cache
   chmod -R 755 public
   ```
4. **Set up storage**:
   ```bash
   # For shared hosting (no symlinks)
   php artisan storage:setup-no-symlink --copy
   # OR for servers with symlink support
   php artisan storage:link
   ```
5. **Run migrations**:
   ```bash
   php artisan migrate --force
   ```
6. **Optimize for production**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan event:cache
   ```

## Post-Deployment Steps

### 1. Clear All Caches

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 2. Rebuild Caches (Production)

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 3. Set Up Storage

**For Shared Hosting (Recommended - No Symlinks):**
```bash
php artisan storage:setup-no-symlink --copy
```

Add to `.env`:
```env
STORAGE_TYPE=copy
```

**For Servers with Symlink Support:**
```bash
php artisan storage:link
```

Add to `.env`:
```env
STORAGE_TYPE=symlink
```

See `SYMLINK_FIX.md` for detailed information about storage setup options.

### 4. Run Database Migrations

```bash
php artisan migrate --force
```

### 5. Seed Database (if needed)

```bash
php artisan db:seed --force
```

### 6. Set File Permissions

```bash
# Storage and cache directories
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Public directory
chmod -R 755 public

# Ensure .env is readable but secure
chmod 644 .env
```

## File Structure on Server

```
your-domain.com/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          # Document root (if Option 1)
│   ├── index.php
│   ├── .htaccess
│   ├── build/
│   └── storage -> ../storage/app/public
├── resources/
├── routes/
├── storage/
│   ├── app/
│   │   └── public/  # Linked to public/storage
│   ├── framework/
│   └── logs/
├── vendor/
├── .env
├── .htaccess        # For Option 2 (root directory)
├── index.php        # For Option 2 (root directory)
├── composer.json
└── artisan
```

## Security Checklist

- [ ] `.env` file is not publicly accessible (check `.htaccess`)
- [ ] `APP_DEBUG=false` in production
- [ ] `APP_KEY` is set and secure
- [ ] Database credentials are secure
- [ ] File permissions are set correctly (755 for directories, 644 for files)
- [ ] Storage directory is not directly accessible
- [ ] Sensitive files are protected by `.htaccess`

## Performance Optimization

### 1. Enable Caching

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 2. Optimize Autoloader

```bash
composer dump-autoload --optimize --classmap-authoritative
```

### 3. Enable OPcache (if available)

Add to `php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
```

## Troubleshooting

### Issue: 500 Internal Server Error

1. Check `.env` file exists and is configured correctly
2. Check file permissions (storage, bootstrap/cache should be 755)
3. Check error logs: `storage/logs/laravel.log`
4. Verify `APP_KEY` is set
5. Check `.htaccess` file exists and is correct

### Issue: Assets Not Loading

1. Run `npm run build` to rebuild assets
2. Check `public/build/` directory exists
3. Verify `ASSET_URL` in `.env` (leave empty for same domain)
4. Clear browser cache

### Issue: Storage Files Not Accessible

1. **For shared hosting (no symlinks):**
   ```bash
   php artisan storage:setup-no-symlink --copy
   ```
   Add `STORAGE_TYPE=copy` to `.env`

2. **For servers with symlinks:**
   ```bash
   php artisan storage:link
   ```
   Add `STORAGE_TYPE=symlink` to `.env`

3. Check `public/storage` directory/symlink exists
4. Verify storage directory permissions (755)
5. See `SYMLINK_FIX.md` for detailed troubleshooting

### Issue: Database Connection Error

1. Verify database credentials in `.env`
2. Check database host (may need to use `localhost` or IP)
3. Verify database user has proper permissions
4. Check if database exists

## Maintenance Mode

To put the site in maintenance mode:

```bash
php artisan down
```

To bring it back up:

```bash
php artisan up
```

## Updates

When updating the application:

1. Pull latest changes
2. Run `composer install --no-dev --optimize-autoloader`
3. Run `npm install && npm run build`
4. Run `php artisan migrate --force`
5. Clear and rebuild caches:
   ```bash
   php artisan cache:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## Support

For issues or questions, check:
- Laravel Documentation: https://laravel.com/docs
- Application logs: `storage/logs/laravel.log`

