# Fixing Symlink Issues on Shared Hosting

Shared hosting providers often don't allow symlinks for security reasons. This guide provides solutions to work around this limitation.

**Note:** If your files are in `public_html` instead of `public`, the application will automatically detect this. See `PUBLIC_HTML_SETUP.md` for details.

## Solution 1: Use Copy Mode (Recommended for Shared Hosting)

This solution creates a real `public/storage` directory and copies files from `storage/app/public` to it.

### Setup Steps

1. **Run the setup command:**
   ```bash
   php artisan storage:setup-no-symlink
   ```

2. **Update your `.env` file:**
   ```env
   STORAGE_TYPE=copy
   ```

3. **Copy existing files (optional):**
   ```bash
   php artisan storage:setup-no-symlink --copy
   ```

### How It Works

- Files are stored in `storage/app/public` (as normal)
- Files are automatically copied to `public/storage` for web access
- The `StorageServiceProvider` syncs files after each request
- No symlinks required!

### Manual File Sync

If you need to manually sync files:
```bash
php artisan storage:setup-no-symlink --copy
```

## Solution 2: Route-Based File Serving

If you can't use `public/storage` at all, files can be served through a Laravel route.

### Setup Steps

1. **Ensure the route is registered** (already in `routes/web.php`):
   ```php
   Route::get('/storage/{path}', [StorageController::class, 'serve'])
       ->where('path', '.*');
   ```

2. **Update your `.env` file:**
   ```env
   STORAGE_TYPE=route
   ```

3. **Update `config/filesystems.php`** to use route URLs:
   ```php
   'public' => [
       'url' => env('APP_URL').'/storage',
       // ...
   ],
   ```

### How It Works

- Files are stored in `storage/app/public`
- Files are served through Laravel route `/storage/{path}`
- No public directory needed
- Slightly slower but works everywhere

## Solution 3: Direct Public Storage (Simple but Less Secure)

Store files directly in `public/storage` instead of using Laravel's storage system.

### Setup Steps

1. **Create public/storage directory:**
   ```bash
   mkdir -p public/storage
   chmod 755 public/storage
   ```

2. **Update filesystem config** to use public path:
   ```php
   'public' => [
       'root' => public_path('storage'),
       'url' => env('APP_URL').'/storage',
   ],
   ```

**Note:** This is less secure as files are directly in the public directory.

## Checking Your Setup

Run this command to check your storage setup:

```bash
php artisan tinker
```

Then run:
```php
\App\Helpers\StorageHelper::checkStorage();
```

## Troubleshooting

### Issue: Files not accessible

1. **Check permissions:**
   ```bash
   chmod -R 755 storage
   chmod -R 755 public/storage
   ```

2. **Verify .env setting:**
   ```env
   STORAGE_TYPE=copy  # or 'route' or 'symlink'
   ```

3. **Clear config cache:**
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

### Issue: Files not syncing

The `StorageServiceProvider` syncs files after each request. For better performance, you can:

1. **Use a queue job** for file syncing (recommended for production)
2. **Manually sync** when needed:
   ```bash
   php artisan storage:setup-no-symlink --copy
   ```

### Issue: 404 errors on storage files

1. **Check if route exists:**
   ```bash
   php artisan route:list | grep storage
   ```

2. **Verify file exists:**
   ```bash
   ls -la storage/app/public/
   ```

3. **Check .htaccess** in public/storage (should allow file access)

## Recommended Setup for Shared Hosting

```env
# .env
STORAGE_TYPE=copy
APP_ENV=production
APP_DEBUG=false
```

Then run:
```bash
php artisan storage:setup-no-symlink --copy
php artisan config:cache
```

This setup:
- ✅ Works without symlinks
- ✅ Files accessible via web
- ✅ Automatic syncing
- ✅ Secure (files not directly in public)

## Migration from Symlink to Copy Mode

If you're migrating from symlink to copy mode:

1. **Remove existing symlink:**
   ```bash
   rm public/storage  # if it's a symlink
   ```

2. **Run setup:**
   ```bash
   php artisan storage:setup-no-symlink --copy
   ```

3. **Update .env:**
   ```env
   STORAGE_TYPE=copy
   ```

4. **Clear cache:**
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

## Performance Considerations

- **Copy Mode:** Files are synced after each request (lightweight, only new/modified files)
- **Route Mode:** Files served through PHP (slightly slower, but works everywhere)
- **Symlink Mode:** Fastest, but not available on all shared hosting

For production, consider using a queue job for file syncing in copy mode.

