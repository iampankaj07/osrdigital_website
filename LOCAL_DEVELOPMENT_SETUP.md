# Local Development Setup Guide

## 🚀 Quick Start for Local Development

### Option 1: Using Laravel's Built-in Server (Recommended)

```bash
# Navigate to your project directory
cd /Users/sushridad/Sites/OSR

# Start the development server
php artisan serve
```

This will start the server at `http://localhost:8000`

### Option 2: Using Valet (if you have Laravel Valet installed)

```bash
# Link the project
valet link osr

# Access via: http://osr.test
```

### Option 3: Using XAMPP/MAMP

1. **Point document root to the `public` folder:**
   ```
   Document Root: /Users/sushridad/Sites/OSR/public
   ```

2. **Access via:** `http://localhost/OSR` or `http://osr.test`

## 🔧 Configuration

### 1. Environment File
Make sure your `.env` file is configured for local development:

```env
APP_NAME="OSR Digital"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
ASSET_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=osr_digital
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Database Setup
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE osr_digital;"

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed
```

### 3. Frontend Assets
```bash
# Install dependencies
npm install

# Build assets for development
npm run dev

# Or watch for changes
npm run watch
```

## 🧪 Testing Your Setup

### 1. Test PHP Setup
Visit: `http://localhost:8000/test-local.php`

### 2. Test Laravel Application
Visit: `http://localhost:8000/`

### 3. Test Admin Panel
Visit: `http://localhost:8000/admin`

## 🔍 Troubleshooting

### Issue: "Class not found" errors
**Solution:**
```bash
composer dump-autoload
```

### Issue: "No application encryption key has been specified"
**Solution:**
```bash
php artisan key:generate
```

### Issue: Database connection errors
**Solution:**
1. Check your `.env` file database settings
2. Make sure MySQL is running
3. Verify database exists

### Issue: Assets not loading
**Solution:**
```bash
npm run build
# or
npm run dev
```

### Issue: 500 Internal Server Error
**Solution:**
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Regenerate key
php artisan key:generate
```

## 📁 File Structure for Local Development

```
OSR/
├── app/                    # Application code
├── bootstrap/              # Bootstrap files
├── config/                 # Configuration files
├── database/               # Migrations and seeders
├── public/                 # ← Document root for local dev
│   ├── index.php          # Laravel entry point
│   ├── .htaccess          # Apache configuration
│   ├── build/             # Compiled assets
│   └── storage -> ../storage/app/public
├── resources/              # Views, CSS, JS
├── routes/                 # Route definitions
├── storage/                # File storage
├── vendor/                 # Composer dependencies
├── .env                    # Environment configuration
├── artisan                 # Laravel command line
└── composer.json           # PHP dependencies
```

## 🎯 Expected Results

After proper setup, you should see:
- ✅ Homepage loads at `http://localhost:8000/`
- ✅ Admin panel accessible at `/admin`
- ✅ Assets load correctly (CSS, JS, images)
- ✅ Database connection works
- ✅ All pages function properly

## 🚀 Development Commands

```bash
# Start development server
php artisan serve

# Watch for file changes
npm run watch

# Build production assets
npm run build

# Run tests
php artisan test

# Clear caches
php artisan optimize:clear
```

---

**For local development, always use the `public` folder as your document root!** 🎯
