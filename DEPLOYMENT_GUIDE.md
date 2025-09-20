# Laravel Cloud Deployment Guide

## Logo Upload/Display Issue Fix

This guide addresses the issue where logos upload successfully but don't display on frontend and backend when deployed to Laravel Cloud.

### Problem Analysis

The issue occurs because:
1. Laravel Cloud may not automatically create storage symbolic links
2. APP_URL environment variable might not be properly configured
3. File permissions or storage paths may differ in cloud environment

### Solution Implementation

### 1. Pre-Deployment Setup

**Update your Laravel Cloud environment variables:**

```bash
APP_URL=https://your-actual-domain.laravel-cloud.com
FILESYSTEM_DISK=public
```

Make sure `APP_URL` matches your actual cloud domain (not localhost).

### 2. Deployment Script

Run the deployment script after each deployment:

```bash
./deploy-cloud.sh
```

This script will:
- Create storage symbolic links
- Clear and optimize caches
- Set proper file permissions
- Test storage configuration
- Create logos directory if missing

### 3. Manual Steps (if deployment script doesn't work)

```bash
# Create storage link
php artisan storage:link

# Clear caches
php artisan cache:clear
php artisan config:clear

# Test storage
php artisan storage:test
```

### 4. Verify Configuration

After deployment, check:

1. **Storage Link**: `public/storage` should be a symbolic link to `../storage/app/public`
2. **APP_URL**: Should match your cloud domain exactly
3. **Logo Files**: Should exist in `storage/app/public/logos/`
4. **File Permissions**: Storage directories should be writable (775)

### 5. Test Logo Display

1. Upload a logo through the admin panel
2. Check if it appears in:
   - Admin panel logo field
   - Frontend header/footer
   - Email templates (if applicable)

### 6. Fallback System

The system now includes:
- Automatic fallback to placeholder logo if file is missing
- Better error logging for debugging
- Multiple logo type support (main, mobile, footer, email)

### 7. Common Issues & Solutions

**Issue**: Logo shows in admin but not frontend
**Solution**: Clear frontend cache and verify APP_URL setting

**Issue**: 404 errors for logo files
**Solution**: Run `php artisan storage:link` and check file permissions

**Issue**: Upload succeeds but file doesn't exist
**Solution**: Check storage disk configuration and write permissions

**Issue**: Wrong domain in logo URLs
**Solution**: Update APP_URL environment variable to match cloud domain

### 8. Environment-Specific Configuration

For Laravel Cloud, use these settings:

```env
FILESYSTEM_DISK=public
APP_URL=https://your-domain.laravel-cloud.com
```

Never use `localhost` or local development URLs in production APP_URL.

### 9. Monitoring & Debugging

Check logs for storage-related errors:
```bash
tail -f storage/logs/laravel.log | grep -i logo
```

Test storage configuration:
```bash
php artisan storage:test
```

### 10. Alternative: Cloud Storage

If local storage continues to have issues, consider switching to cloud storage (S3, etc.):

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket
```

Then update FilamentServiceProvider to use S3 disk for uploads.

---

## Quick Checklist

- [ ] APP_URL set correctly in environment
- [ ] Storage link created (`php artisan storage:link`)
- [ ] Caches cleared
- [ ] File permissions set (775 for storage directories)
- [ ] Logo files exist in storage/app/public/logos/
- [ ] Frontend and backend both display logos correctly
- [ ] Placeholder system working as fallback

## Support

If issues persist, check:
1. Laravel Cloud deployment logs
2. Browser network tab for 404/403 errors on logo URLs
3. Storage permissions and ownership
4. Environment variable configuration
