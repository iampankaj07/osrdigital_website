@echo off
REM OSR Digital Production Build Script for Windows
REM This script prepares the application for shared hosting deployment

echo 🚀 Starting OSR Digital Production Build...

REM Check if we're in the right directory
if not exist "artisan" (
    echo [ERROR] Please run this script from the Laravel project root directory
    pause
    exit /b 1
)

REM Step 1: Install/Update Dependencies
echo [INFO] Installing PHP dependencies...
composer install --optimize-autoloader --no-dev --no-interaction

if %errorlevel% neq 0 (
    echo [ERROR] Failed to install PHP dependencies
    pause
    exit /b 1
)

REM Step 2: Install/Update Node dependencies
echo [INFO] Installing Node.js dependencies...
npm install --production

if %errorlevel% neq 0 (
    echo [ERROR] Failed to install Node.js dependencies
    pause
    exit /b 1
)

REM Step 3: Build assets for production
echo [INFO] Building assets for production...
npm run build

if %errorlevel% neq 0 (
    echo [ERROR] Failed to build assets
    pause
    exit /b 1
)

REM Step 4: Generate application key if not exists
if not exist ".env" (
    echo [WARNING] .env file not found. Creating from .env.example...
    copy .env.example .env
)

echo [INFO] Generating application key...
php artisan key:generate --force

REM Step 5: Clear and cache configurations
echo [INFO] Clearing and caching configurations...
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

REM Step 6: Cache configurations for production
echo [INFO] Caching configurations for production...
php artisan config:cache
php artisan route:cache
php artisan view:cache

REM Step 7: Create storage link
echo [INFO] Creating storage link...
php artisan storage:link

REM Step 8: Create deployment info file
echo [INFO] Creating deployment information...
(
echo OSR Digital Deployment Information
echo ==================================
echo.
echo Build Date: %date% %time%
echo Build Version: unknown
echo PHP Version: 
php -v
echo.
echo Deployment Checklist:
echo - [ ] Upload all files to shared hosting
echo - [ ] Point document root to 'public' folder
echo - [ ] Configure .env file with production settings
echo - [ ] Set up database and run migrations
echo - [ ] Run: php artisan migrate --force
echo - [ ] Run: php artisan db:seed --force
echo - [ ] Set proper file permissions
echo - [ ] Test the application
echo.
echo Important Files to Upload:
echo - All files except: node_modules, .git, tests
echo - Ensure .env is configured for production
echo - Make sure public/build directory exists
echo.
echo Security Notes:
echo - Set APP_DEBUG=false in .env
echo - Set APP_ENV=production in .env
echo - Use strong database passwords
echo - Enable HTTPS/SSL
echo.
echo Support:
echo - Documentation: README.md
echo - Deployment Guide: SHARED_HOSTING_DEPLOYMENT.md
echo - Issues: Check storage/logs/laravel.log for errors
) > deployment-info.txt

echo [INFO] Deployment information saved to deployment-info.txt

REM Step 9: Check if build directory exists
if exist "public\build" (
    echo [INFO] ✅ Assets built successfully in public/build/
) else (
    echo [ERROR] ❌ Assets build failed - public/build/ directory not found
    pause
    exit /b 1
)

echo [INFO] 🚀 Ready for shared hosting deployment!
echo.
echo Next steps:
echo 1. Upload all files to your shared hosting (except excluded files)
echo 2. Point your subdomain's document root to the 'public' folder
echo 3. Configure your .env file with production settings
echo 4. Set up your database and run migrations
echo 5. Test your application
echo.
echo Files to exclude from upload:
echo - node_modules/
echo - .git/
echo - tests/
echo - .env (configure on server)
echo - storage/logs/ (will be created automatically)
echo.
echo Check deployment-info.txt for detailed instructions
echo.
pause
