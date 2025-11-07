# Quick Deployment Reference

## Quick Commands

### Initial Deployment
```bash
# 1. Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Configure .env (edit with your settings)
# - Database credentials
# - APP_URL
# - Mail settings
# - Set APP_DEBUG=false

# 4. Run migrations and optimize
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Set permissions
chmod -R 755 storage bootstrap/cache public
```

### Using the Deployment Script
```bash
./deploy.sh
```

## Essential .env Settings for Shared Hosting

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

HOSTING_ENV=shared
SESSION_DRIVER=database
CACHE_DRIVER=database
```

## File Permissions

```bash
# Directories
chmod 755 storage bootstrap/cache public

# Files
chmod 644 .env
```

## Common Issues & Fixes

| Issue | Solution |
|-------|----------|
| 500 Error | Check permissions, .env file, APP_KEY |
| Assets 404 | Run `npm run build` |
| Storage 404 | Run `php artisan storage:link` |
| Database Error | Verify credentials, check host (try `localhost`) |

## Maintenance Commands

```bash
# Put site in maintenance
php artisan down

# Bring site back up
php artisan up

# Clear all caches
php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear

# Rebuild caches
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

