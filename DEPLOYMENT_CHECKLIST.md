# OSR Digital Deployment Checklist

## 🚀 Pre-Deployment

### 1. Build Assets
- [ ] Run `npm install` to install dependencies
- [ ] Run `npm run build` to build production assets
- [ ] Verify `public/build/` directory exists with assets
- [ ] Run `composer install --optimize-autoloader --no-dev`

### 2. Environment Configuration
- [ ] Create `.env` file for production
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_URL=https://your-subdomain.yourdomain.com`
- [ ] Configure database credentials
- [ ] Set `ASSET_URL` if needed for subdomain

### 3. Security Settings
- [ ] Generate new `APP_KEY`
- [ ] Use strong database passwords
- [ ] Set `SESSION_SECURE_COOKIE=true` for HTTPS
- [ ] Configure mail settings

## 📁 File Upload

### 1. Files to Upload
- [ ] All application files (app/, config/, database/, etc.)
- [ ] `public/` directory (document root)
- [ ] `vendor/` directory
- [ ] `.env` file (configured for production)
- [ ] `artisan` file
- [ ] `composer.json` and `composer.lock`

### 2. Files to Exclude
- [ ] `node_modules/` (not needed on server)
- [ ] `.git/` directory
- [ ] `tests/` directory
- [ ] `storage/logs/` (will be created automatically)
- [ ] Development files (`.env.example`, `vite.config.js`, etc.)

### 3. Directory Structure
```
your-subdomain/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          ← Document root
│   ├── index.php
│   ├── .htaccess
│   └── build/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── artisan
├── composer.json
└── composer.lock
```

## ⚙️ Server Configuration

### 1. Document Root
- [ ] Point subdomain to `public/` folder
- [ ] Verify `public/index.php` is accessible
- [ ] Test basic Laravel installation

### 2. PHP Configuration
- [ ] PHP 8.1+ enabled
- [ ] Required extensions installed:
  - [ ] BCMath
  - [ ] Ctype
  - [ ] cURL
  - [ ] DOM
  - [ ] Fileinfo
  - [ ] JSON
  - [ ] Mbstring
  - [ ] OpenSSL
  - [ ] PCRE
  - [ ] PDO
  - [ ] Tokenizer
  - [ ] XML
  - [ ] ZIP

### 3. Database Setup
- [ ] Create MySQL database
- [ ] Create database user with full privileges
- [ ] Test database connection
- [ ] Update `.env` with database credentials

## 🔧 Post-Deployment

### 1. Laravel Setup
- [ ] Run `php artisan key:generate`
- [ ] Run `php artisan migrate --force`
- [ ] Run `php artisan db:seed --force`
- [ ] Run `php artisan storage:link`

### 2. Cache Configuration
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`

### 3. File Permissions
- [ ] Set `storage/` to 755
- [ ] Set `bootstrap/cache/` to 755
- [ ] Set `public/` to 755
- [ ] Set `.env` to 600 (if possible)

### 4. SSL/HTTPS
- [ ] Install SSL certificate
- [ ] Force HTTPS redirect (uncomment in .htaccess)
- [ ] Update `APP_URL` to use HTTPS
- [ ] Test HTTPS functionality

## 🧪 Testing

### 1. Basic Functionality
- [ ] Homepage loads correctly
- [ ] Admin panel accessible at `/admin`
- [ ] Login works (admin@osrdigital.com / password)
- [ ] All pages load without errors
- [ ] Assets (CSS/JS) load correctly

### 2. Database Functionality
- [ ] Content displays correctly
- [ ] Admin panel functions work
- [ ] File uploads work
- [ ] Forms submit successfully

### 3. Performance
- [ ] Page load times are acceptable
- [ ] Images load correctly
- [ ] No 404 errors for assets
- [ ] Caching is working

## 🔒 Security Verification

### 1. File Security
- [ ] `.env` file is not accessible via web
- [ ] `artisan` file is not accessible via web
- [ ] Sensitive files are protected
- [ ] Directory browsing is disabled

### 2. Application Security
- [ ] Debug mode is disabled
- [ ] Error pages don't expose sensitive information
- [ ] CSRF protection is working
- [ ] SQL injection protection is active

## 📊 Monitoring

### 1. Logs
- [ ] Check `storage/logs/laravel.log` for errors
- [ ] Monitor server error logs
- [ ] Set up log rotation if needed

### 2. Performance
- [ ] Monitor page load times
- [ ] Check database query performance
- [ ] Monitor memory usage

## 🎉 Go Live

### 1. Final Checks
- [ ] All tests pass
- [ ] No errors in logs
- [ ] Performance is acceptable
- [ ] Security measures are in place

### 2. DNS/Subdomain
- [ ] Subdomain points to correct server
- [ ] SSL certificate is active
- [ ] Domain propagation is complete

### 3. Backup
- [ ] Database backup created
- [ ] File backup created
- [ ] Backup strategy in place

## 🆘 Troubleshooting

### Common Issues
- **500 Error**: Check file permissions and .env configuration
- **Assets not loading**: Verify `public/build/` exists and `ASSET_URL` is set
- **Database errors**: Check credentials and connection
- **Permission errors**: Verify file permissions are set correctly

### Support Resources
- [ ] Check `storage/logs/laravel.log`
- [ ] Review server error logs
- [ ] Consult `SHARED_HOSTING_DEPLOYMENT.md`
- [ ] Check `README.md` for additional help

---

**Deployment Date**: ___________  
**Deployed By**: ___________  
**Server**: ___________  
**Domain**: ___________  

**Notes**:
_________________________________
_________________________________
_________________________________
