# OSR Digital - Ready for Shared Hosting Deployment

## 🎉 Your application is now ready for shared hosting deployment!

This document provides a quick reference for deploying OSR Digital to shared hosting while ensuring it works on both localhost and subdomains.

## 📋 Quick Start Guide

### 1. Build for Production
```bash
# Run the production build script
./build-production.sh

# Or on Windows:
build-production.bat
```

### 2. Upload Files
Upload all files to your shared hosting **except**:
- `node_modules/`
- `.git/`
- `tests/`
- `storage/logs/` (will be created automatically)

### 3. Configure Server
**Option A: Root Directory (Recommended)**
- Point your subdomain's document root to the main application folder
- Ensure PHP 8.1+ is enabled
- Create a MySQL database

**Option B: Public Folder**
- Point your subdomain's document root to the `public/` folder
- Ensure PHP 8.1+ is enabled
- Create a MySQL database

### 4. Configure Environment
Create a `.env` file with your production settings:
```env
APP_NAME="OSR Digital"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-subdomain.yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Add other settings as needed
```

### 5. Deploy on Server
```bash
# Run the deployment script on your server
./deploy-on-server.sh
```

## 🔧 Key Features for Shared Hosting

### ✅ Automatic Environment Detection
- Detects localhost vs shared hosting automatically
- Applies appropriate optimizations
- Handles URL generation correctly

### ✅ Production-Ready .htaccess
- Security headers included
- Gzip compression enabled
- Cache control optimized
- Sensitive files protected

### ✅ Optimized Build Process
- Assets minified and optimized
- Chunks split for better loading
- Source maps disabled for production
- Vendor libraries separated

### ✅ Database Optimizations
- Uses database for sessions and cache
- Optimized for shared hosting limitations
- Proper indexing for performance

### ✅ Security Features
- CSRF protection enabled
- XSS protection headers
- Clickjacking prevention
- Secure file access controls

## 📁 File Structure

```
your-subdomain/
├── app/                    # Application code
├── bootstrap/              # Bootstrap files
├── config/                 # Configuration files
├── database/               # Migrations and seeders
├── public/                 # Public assets and files
│   ├── index.php          # Laravel entry point (for public folder setup)
│   ├── .htaccess          # Apache configuration (for public folder setup)
│   ├── build/             # Compiled assets
│   └── storage -> ../storage/app/public
├── resources/              # Views, CSS, JS
├── routes/                 # Route definitions
├── storage/                # File storage
├── vendor/                 # Composer dependencies
├── .env                    # Environment configuration
├── .htaccess               # Root-level Apache configuration (for root setup)
├── index.php               # Root-level Laravel entry point (for root setup)
├── artisan                 # Laravel command line
├── composer.json           # PHP dependencies
└── composer.lock           # Locked PHP dependencies
```

**Document Root Options:**
- **Root Directory**: Point to main folder (recommended)
- **Public Folder**: Point to `public/` folder

## 🚀 Deployment Scripts

### `build-production.sh` / `build-production.bat`
- Installs dependencies
- Builds production assets
- Optimizes for deployment
- Creates deployment info

### `deploy-on-server.sh`
- Runs migrations
- Seeds database
- Sets up caches
- Configures permissions

## 📚 Documentation

- **Main Guide**: `SHARED_HOSTING_DEPLOYMENT.md`
- **Checklist**: `DEPLOYMENT_CHECKLIST.md`
- **Installation**: `INSTALLATION.md`
- **API Docs**: `API.md`
- **Contributing**: `CONTRIBUTING.md`

## 🔍 Troubleshooting

### Common Issues

#### 500 Internal Server Error
1. Check file permissions: `chmod -R 755 storage bootstrap/cache public`
2. Verify `.env` file exists and is configured
3. Check PHP error logs
4. Ensure all required PHP extensions are installed

#### Assets Not Loading
1. Verify `public/build/` directory exists
2. Check if `ASSET_URL` is set in `.env`
3. Ensure `npm run build` was executed
4. Check file permissions on `public/` directory

#### Database Connection Issues
1. Verify database credentials in `.env`
2. Check if database server is accessible
3. Ensure database user has proper permissions
4. Test connection with simple PHP script

#### Permission Errors
1. Set storage permissions: `chmod -R 755 storage`
2. Set cache permissions: `chmod -R 755 bootstrap/cache`
3. Set public permissions: `chmod -R 755 public`
4. Check if web server can write to storage

### Debug Steps
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify `.env` configuration
3. Test database connection
4. Check file permissions
5. Verify PHP version and extensions

## 🎯 Success Indicators

Your deployment is successful when:
- ✅ Homepage loads at `https://your-subdomain.yourdomain.com`
- ✅ Admin panel accessible at `/admin`
- ✅ Login works with `admin@osrdigital.com` / `password`
- ✅ All pages load without errors
- ✅ Assets (CSS/JS) load correctly
- ✅ File uploads work
- ✅ Forms submit successfully

## 🔒 Security Checklist

- [ ] `APP_DEBUG=false` in `.env`
- [ ] `APP_ENV=production` in `.env`
- [ ] Strong database passwords
- [ ] HTTPS/SSL enabled
- [ ] `.env` file not accessible via web
- [ ] Sensitive files protected
- [ ] Directory browsing disabled

## 📞 Support

If you need help:
1. Check the troubleshooting section above
2. Review the deployment documentation
3. Check Laravel logs for specific errors
4. Contact your hosting provider for server issues

## 🎉 Ready to Deploy!

Your OSR Digital application is now fully prepared for shared hosting deployment. Follow the steps above and you'll have a professional, secure, and optimized website running on your subdomain.

**Good luck with your deployment!** 🚀
