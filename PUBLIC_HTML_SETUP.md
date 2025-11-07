# Public HTML Setup Guide

This guide explains how to set up the application when files are uploaded to `public_html` (common in shared hosting).

## Understanding the Structure

On shared hosting, the document root is typically `public_html` as a sibling directory:

```
/home/username/
├── osr/                  # Full Laravel project
│   ├── app/
│   ├── storage/          # Laravel storage (not web accessible)
│   │   └── app/
│   │       └── public/   # Source files (copied to public_html/storage)
│   ├── vendor/
│   └── .env
└── public_html/          # Document root (web accessible)
    ├── index.php         # Contents of laravel/public
    ├── storage/          # Storage files go here (copied from osr/storage/app/public)
    └── build/            # Compiled assets
```

## Automatic Detection

The application automatically detects `public_html` in the following order:

1. **Environment variable** `PUBLIC_PATH` (highest priority)
2. **Sibling directory** - If your project is in `/home/username/osr`, it checks `/home/username/public_html`
3. **Inside project** - Checks `osr/public_html` (if it exists)
4. **Standard public** - Falls back to `osr/public`

You typically don't need to configure anything - it will auto-detect!

## Manual Configuration

If automatic detection doesn't work, you can set it manually in `.env`:

```env
PUBLIC_PATH=/home/username/public_html
STORAGE_TYPE=copy
```

## Setup Steps

### 1. Run Storage Setup

```bash
php artisan storage:setup-no-symlink --copy
```

This will:
- Detect `public_html` automatically
- Create `public_html/storage` directory
- Copy files from `storage/app/public` to `public_html/storage`
- Set up required subdirectories

### 2. Configure .env

```env
# Storage configuration
STORAGE_TYPE=copy

# Optional: If auto-detection doesn't work
PUBLIC_PATH=/path/to/public_html

# Application URL
APP_URL=https://yourdomain.com
```

### 3. Verify Setup

Check if storage is set up correctly:

```bash
php artisan tinker
```

Then:
```php
\App\Helpers\StorageHelper::checkStorage();
```

## How It Works

1. **Files are stored** in `storage/app/public` (standard Laravel location)
2. **Files are copied** to `public_html/storage` for web access
3. **Automatic syncing** happens after each request (only new/modified files)
4. **No symlinks required** - works on all shared hosting

## File Structure

### Storage Location
- **Source:** `/home/username/osr/storage/app/public/` (Laravel storage)
- **Public:** `/home/username/public_html/storage/` (web accessible)

### Subdirectories Created
- `associates/`
- `film-portfolios/`
- `team-avatars/`
- `testimonials/`
- `partner-logos/`
- `news/`
- `general/`
- `hero-sliders/`

## Troubleshooting

### Issue: Files not accessible

1. **Check if `public_html/storage` exists:**
   ```bash
   ls -la public_html/storage
   ```

2. **Verify permissions:**
   ```bash
   chmod -R 755 public_html/storage
   ```

3. **Check .env configuration:**
   ```env
   STORAGE_TYPE=copy
   PUBLIC_PATH=/path/to/public_html  # If needed
   ```

4. **Re-run setup:**
   ```bash
   php artisan storage:setup-no-symlink --copy --force
   ```

### Issue: Auto-detection not working

Set `PUBLIC_PATH` manually in `.env`:

```env
PUBLIC_PATH=/home/username/public_html
```

Then clear config cache:
```bash
php artisan config:clear
php artisan config:cache
```

### Issue: Files not syncing

1. **Check if StorageServiceProvider is registered:**
   ```bash
   php artisan route:list | grep storage
   ```

2. **Verify .env setting:**
   ```env
   STORAGE_TYPE=copy
   ```

3. **Manually sync files:**
   ```bash
   php artisan storage:setup-no-symlink --copy
   ```

## Deployment Checklist

- [ ] Run `php artisan storage:setup-no-symlink --copy`
- [ ] Set `STORAGE_TYPE=copy` in `.env`
- [ ] Set `PUBLIC_PATH` if auto-detection fails
- [ ] Verify `public_html/storage` directory exists
- [ ] Check file permissions (755)
- [ ] Test file uploads
- [ ] Test file access via web

## Benefits

- ✅ Works with `public_html` structure
- ✅ No symlinks required
- ✅ Automatic file syncing
- ✅ Secure (source files not directly web accessible)
- ✅ Compatible with all shared hosting providers

## Notes

- Files are stored in `storage/app/public` (standard Laravel)
- Files are copied to `public_html/storage` for web access
- Syncing happens automatically after each request
- Only new/modified files are synced (lightweight)

Your application is now ready for `public_html` deployment! 🚀

