# Root Directory Setup Guide

This guide explains how to set up OSR Digital to work directly from the root directory without requiring the `/public` folder in the URL.

## 🎯 Benefits of Root Directory Setup

- ✅ **Clean URLs**: No `/public` in the URL
- ✅ **Easier Setup**: Point subdomain directly to main folder
- ✅ **Better Security**: Application files are not directly accessible
- ✅ **Simpler Management**: All files in one location

## 📁 File Structure

When using root directory setup, your subdomain points to the main application folder:

```
your-subdomain/
├── app/                    # Application code
├── bootstrap/              # Bootstrap files
├── config/                 # Configuration files
├── database/               # Migrations and seeders
├── public/                 # Public assets (build/, images/, etc.)
│   ├── build/             # Compiled assets
│   ├── images/            # Public images
│   └── storage -> ../storage/app/public
├── resources/              # Views, CSS, JS
├── routes/                 # Route definitions
├── storage/                # File storage
├── vendor/                 # Composer dependencies
├── .env                    # Environment configuration
├── .htaccess               # Root-level Apache configuration
├── index.php               # Root-level Laravel entry point
├── artisan                 # Laravel command line
├── composer.json           # PHP dependencies
└── composer.lock           # Locked PHP dependencies
```

## ⚙️ Configuration

### 1. Document Root
Point your subdomain's document root to the main application folder:
```
Document Root: /path/to/your-subdomain
```

### 2. Environment Variables
In your `.env` file, set:
```env
APP_URL=https://your-subdomain.yourdomain.com
ASSET_URL=https://your-subdomain.yourdomain.com/public
```

### 3. Vite Configuration
The Vite configuration is already set up to build assets with the correct path:
```javascript
base: process.env.NODE_ENV === 'production' ? '/public/' : '/',
```

## 🔧 How It Works

### 1. Root-Level Files
- **`index.php`**: Laravel entry point that handles all requests
- **`.htaccess`**: Apache configuration that routes requests to `index.php`

### 2. Asset Handling
- Assets are built to `public/build/` directory
- Vite generates URLs with `/public/` prefix
- Laravel serves assets from the correct location

### 3. Request Flow
1. User visits `https://your-subdomain.yourdomain.com`
2. Apache `.htaccess` routes request to `index.php`
3. Laravel handles the request and serves the application
4. Assets are loaded from `/public/build/` directory

## 🚀 Deployment Steps

### 1. Build Assets
```bash
npm run build
```

### 2. Upload Files
Upload all files to your subdomain directory (except `node_modules/`, `.git/`, `tests/`)

### 3. Configure Server
- Point document root to main application folder
- Ensure PHP 8.1+ is enabled
- Create MySQL database

### 4. Configure Environment
Create `.env` file with your production settings:
```env
APP_NAME="OSR Digital"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-subdomain.yourdomain.com
ASSET_URL=https://your-subdomain.yourdomain.com/public

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 5. Deploy on Server
```bash
./deploy-on-server.sh
```

## 🔍 Troubleshooting

### Assets Not Loading
1. Check if `public/build/` directory exists
2. Verify `ASSET_URL` is set correctly in `.env`
3. Ensure `npm run build` was executed
4. Check file permissions on `public/` directory

### 500 Internal Server Error
1. Check file permissions: `chmod -R 755 storage bootstrap/cache public`
2. Verify `.env` file exists and is configured
3. Check PHP error logs
4. Ensure all required PHP extensions are installed

### URL Issues
1. Verify `APP_URL` is set correctly
2. Check if `ASSET_URL` is configured
3. Ensure subdomain points to main folder, not `public/`

## ✅ Verification

Your setup is correct when:
- ✅ Homepage loads at `https://your-subdomain.yourdomain.com`
- ✅ No `/public` in the URL
- ✅ Assets load correctly (CSS, JS, images)
- ✅ Admin panel accessible at `/admin`
- ✅ All pages work without errors

## 🔄 Alternative: Public Folder Setup

If you prefer the traditional Laravel setup:
1. Point document root to `public/` folder
2. Set `ASSET_URL` to your subdomain URL (without `/public`)
3. Use the files in `public/` directory

## 📞 Support

If you encounter issues:
1. Check the troubleshooting section above
2. Review server error logs
3. Verify file permissions
4. Check Laravel logs in `storage/logs/`

---

**Root directory setup provides a cleaner, more professional URL structure for your OSR Digital application!** 🚀
