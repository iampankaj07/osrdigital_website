# Shared Hosting Directory Structure

This document explains the typical shared hosting structure and how the application handles it.

## Standard Structure

```
/home/username/
├── osr/                  # Full Laravel project
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/           # Standard Laravel public (not used in this setup)
│   ├── resources/
│   ├── routes/
│   ├── storage/          # Laravel storage
│   │   ├── app/
│   │   │   └── public/  # Source files (copied to public_html/storage)
│   │   ├── framework/
│   │   └── logs/
│   ├── vendor/
│   ├── .env
│   ├── artisan
│   ├── composer.json
│   └── index.php         # Root index.php (if using root directory setup)
└── public_html/          # Document root (web accessible)
    ├── index.php         # From laravel/public/index.php
    ├── .htaccess         # From laravel/public/.htaccess
    ├── storage/          # Copied from osr/storage/app/public
    │   ├── associates/
    │   ├── film-portfolios/
    │   └── ...
    └── build/            # Compiled assets from osr/public/build
```

## How It Works

### 1. Project Location
- Laravel project is in `/home/username/osr/`
- This is where all your code, vendor, storage, etc. lives

### 2. Document Root
- `public_html/` is the document root (what the web server serves)
- Contains the contents of `laravel/public/`
- This is where visitors access your site

### 3. Storage Files
- **Stored in:** `/home/username/osr/storage/app/public/`
- **Copied to:** `/home/username/public_html/storage/`
- Files are automatically synced after uploads

## Automatic Detection

The application automatically detects this structure:

1. Checks if `public_html` exists as a sibling to your project
2. If project is in `/home/username/osr`, it looks for `/home/username/public_html`
3. No configuration needed in most cases!

## Manual Configuration

If auto-detection doesn't work, set in `.env`:

```env
PUBLIC_PATH=/home/username/public_html
STORAGE_TYPE=copy
```

## Setup Steps

### 1. Upload Files

Upload your Laravel project to `/home/username/osr/` and public files to `/home/username/public_html/`

### 2. Run Storage Setup

```bash
cd /home/username/osr
php artisan storage:setup-no-symlink --copy
```

This will:
- Detect `/home/username/public_html` automatically
- Create `/home/username/public_html/storage/`
- Copy files from `/home/username/osr/storage/app/public/`

### 3. Configure .env

```env
APP_URL=https://yourdomain.com
STORAGE_TYPE=copy
# Optional: If auto-detection doesn't work
PUBLIC_PATH=/home/username/public_html
```

## File Permissions

```bash
# Laravel project
chmod -R 755 /home2/osrdigit/osr/storage
chmod -R 755 /home2/osrdigit/osr/bootstrap/cache

# Public HTML
chmod -R 755 /home2/osrdigit/public_html/storage
chmod 644 /home2/osrdigit/osr/.env
```

## Benefits

- ✅ Standard shared hosting structure
- ✅ Automatic detection
- ✅ No symlinks required
- ✅ Secure (source files not directly web accessible)
- ✅ Works with cPanel and most shared hosting

## Troubleshooting

### Issue: Storage not found

1. **Check if public_html exists:**
   ```bash
   ls -la /home/username/public_html
   ```

2. **Verify auto-detection:**
   ```bash
   php artisan tinker
   ```
   ```php
   \App\Helpers\StorageHelper::detectPublicDirectory();
   ```

3. **Set manually if needed:**
   ```env
   PUBLIC_PATH=/home/username/public_html
   ```

### Issue: Files not syncing

1. **Check permissions:**
   ```bash
   chmod -R 755 /home/username/public_html/storage
   ```

2. **Verify .env:**
   ```env
   STORAGE_TYPE=copy
   ```

3. **Re-run setup:**
   ```bash
   php artisan storage:setup-no-symlink --copy --force
   ```

## Notes

- The `osr/public/` directory is not used in this setup
- All web-accessible files go in `public_html/`
- Storage files are automatically synced from `osr/storage/app/public/` to `public_html/storage/`
- The application handles this structure automatically

Your application is ready for this shared hosting structure! 🚀

