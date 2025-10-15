# Shared Hosting Deployment Guide

This guide will help you deploy OSR Digital to shared hosting while ensuring it works on both localhost and subdomains.

## 🚀 Pre-Deployment Checklist

### 1. Build Assets for Production
```bash
# Install dependencies
npm install

# Build for production
npm run build

# Optimize for production
composer install --optimize-autoloader --no-dev
```

### 2. Environment Configuration
Create a `.env` file with the following settings:

```env
APP_NAME="OSR Digital"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://your-subdomain.yourdomain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Session Configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

# Cache Configuration
CACHE_STORE=database

# Mail Configuration (Update with your hosting provider's SMTP)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@yourdomain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"

# File Storage
FILESYSTEM_DISK=local

# Queue (if supported)
QUEUE_CONNECTION=database
```

## 📁 File Structure for Shared Hosting

### Required Files to Upload
```
your-subdomain/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          # Document root should point here
│   ├── index.php
│   ├── .htaccess
│   ├── build/
│   └── storage -> ../storage/app/public
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── artisan
├── composer.json
└── composer.lock
```

### Files to Exclude
- `.git/`
- `node_modules/`
- `tests/`
- `.env.example`
- `vite.config.js`
- `tailwind.config.js`
- `package.json`
- `package-lock.json`

## ⚙️ Server Configuration

### 1. Document Root
Point your subdomain's document root to the `public` folder:
```
Document Root: /path/to/your-subdomain/public
```

### 2. PHP Version
Ensure PHP 8.1+ is enabled on your hosting account.

### 3. Required PHP Extensions
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PCRE
- PDO
- Tokenizer
- XML
- ZIP

### 4. Database Setup
1. Create a MySQL database
2. Create a database user with full privileges
3. Update the `.env` file with database credentials

## 🔧 Post-Deployment Steps

### 1. Set Permissions
```bash
# Set proper permissions (if you have SSH access)
chmod -R 755 storage bootstrap/cache
chmod -R 755 public
```

### 2. Generate Application Key
```bash
php artisan key:generate
```

### 3. Run Migrations
```bash
php artisan migrate --force
```

### 4. Seed Database
```bash
php artisan db:seed --force
```

### 5. Clear Caches
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Create Storage Link
```bash
php artisan storage:link
```

## 🌐 Subdomain Configuration

### 1. Subdomain Setup
- Create a subdomain in your hosting control panel
- Point it to the `public` folder of your application
- Ensure SSL certificate is installed

### 2. URL Configuration
Update your `.env` file:
```env
APP_URL=https://your-subdomain.yourdomain.com
```

### 3. Asset URL (if needed)
If assets are not loading correctly:
```env
ASSET_URL=https://your-subdomain.yourdomain.com
```

## 🔒 Security Considerations

### 1. File Permissions
- Set `storage/` and `bootstrap/cache/` to 755
- Set `.env` to 600 (if possible)
- Ensure `public/` is accessible

### 2. Environment Security
- Never commit `.env` file
- Use strong database passwords
- Enable HTTPS/SSL

### 3. Laravel Security
- Set `APP_DEBUG=false` in production
- Use `APP_ENV=production`
- Ensure proper file permissions

## 🐛 Troubleshooting

### Common Issues

#### 1. 500 Internal Server Error
- Check file permissions
- Verify `.env` file exists and is configured correctly
- Check PHP error logs
- Ensure all required PHP extensions are installed

#### 2. Assets Not Loading
- Verify `public/build/` directory exists
- Check if `ASSET_URL` is set correctly
- Ensure `npm run build` was executed

#### 3. Database Connection Issues
- Verify database credentials in `.env`
- Check if database server is accessible
- Ensure database user has proper permissions

#### 4. Storage Link Issues
- Run `php artisan storage:link`
- Check if `public/storage` symlink exists
- Verify storage directory permissions

### Debug Steps
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify `.env` configuration
3. Test database connection
4. Check file permissions
5. Verify PHP version and extensions

## 📞 Support

If you encounter issues:
1. Check the troubleshooting section above
2. Review Laravel logs
3. Contact your hosting provider
4. Check the main README.md for additional help

## 🎉 Success!

Once deployed, your OSR Digital application should be accessible at:
- **Frontend**: `https://your-subdomain.yourdomain.com`
- **Admin Panel**: `https://your-subdomain.yourdomain.com/admin`
- **Default Login**: admin@osrdigital.com / password

Remember to change the default admin credentials after first login!
