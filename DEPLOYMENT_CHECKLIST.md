# Deployment Checklist

Use this checklist to ensure a smooth deployment to shared hosting.

## Pre-Deployment

- [ ] All code changes committed and pushed to repository
- [ ] Database backup created (if updating existing site)
- [ ] Tested locally with production-like settings
- [ ] All environment variables documented

## Build & Prepare

- [ ] Run `composer install --no-dev --optimize-autoloader`
- [ ] Run `npm install && npm run build`
- [ ] Verify `public/build/` directory contains compiled assets
- [ ] Check that `vendor/` directory is present

## Environment Configuration

- [ ] `.env` file created from `.env.example`
- [ ] `APP_ENV=production` set
- [ ] `APP_DEBUG=false` set
- [ ] `APP_KEY` generated (run `php artisan key:generate`)
- [ ] `APP_URL` set to production domain
- [ ] Database credentials configured
- [ ] `HOSTING_ENV=shared` set
- [ ] `SESSION_DRIVER=database` set
- [ ] `CACHE_DRIVER=database` set
- [ ] Mail configuration set

## File Upload

- [ ] All files uploaded to server
- [ ] `.env` file uploaded (not `.env.example`)
- [ ] Verify `storage/` directory structure exists
- [ ] Verify `bootstrap/cache/` directory exists

## Server Configuration

- [ ] Document root set correctly (to `public/` if possible, or root with `.htaccess`)
- [ ] PHP version 8.2+ verified
- [ ] Required PHP extensions installed (mbstring, openssl, pdo, tokenizer, xml, ctype, json, fileinfo)

## Permissions

- [ ] `storage/` directory: 755
- [ ] `bootstrap/cache/` directory: 755
- [ ] `public/` directory: 755
- [ ] `.env` file: 644
- [ ] Verify web server can write to `storage/` and `bootstrap/cache/`

## Database Setup

- [ ] Database created on hosting
- [ ] Database user created with proper permissions
- [ ] Database credentials tested
- [ ] Migrations run: `php artisan migrate --force`
- [ ] Seeders run (if needed): `php artisan db:seed --force`

## Laravel Setup

- [ ] Storage link created: `php artisan storage:link`
- [ ] Application key generated: `php artisan key:generate`
- [ ] Config cached: `php artisan config:cache`
- [ ] Routes cached: `php artisan route:cache`
- [ ] Views cached: `php artisan view:cache`
- [ ] Events cached: `php artisan event:cache`

## Security

- [ ] `.env` file not publicly accessible
- [ ] `APP_DEBUG=false` in production
- [ ] Sensitive files protected by `.htaccess`
- [ ] Directory browsing disabled
- [ ] HTTPS enabled (if available)

## Testing

- [ ] Homepage loads correctly
- [ ] Assets (CSS/JS) load correctly
- [ ] Images load correctly
- [ ] Database connections work
- [ ] Forms submit correctly
- [ ] File uploads work
- [ ] Admin panel accessible
- [ ] No errors in browser console
- [ ] Check `storage/logs/laravel.log` for errors

## Performance

- [ ] OPcache enabled (if available)
- [ ] Gzip compression enabled (via `.htaccess`)
- [ ] Browser caching configured
- [ ] All caches built

## Post-Deployment

- [ ] Monitor error logs for first 24 hours
- [ ] Test all critical functionality
- [ ] Verify email sending works
- [ ] Set up automated backups (if available)
- [ ] Document any custom server configurations

## Rollback Plan

- [ ] Backup strategy in place
- [ ] Know how to restore previous version
- [ ] Database rollback plan ready

## Notes

_Add any custom notes or configurations specific to your deployment here:_

