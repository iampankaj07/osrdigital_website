#!/bin/bash

# OSR Digital Production Build Script
# This script prepares the application for shared hosting deployment

echo "🚀 Starting OSR Digital Production Build..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    print_error "Please run this script from the Laravel project root directory"
    exit 1
fi

# Step 1: Install/Update Dependencies
print_status "Installing PHP dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

if [ $? -ne 0 ]; then
    print_error "Failed to install PHP dependencies"
    exit 1
fi

# Step 2: Install/Update Node dependencies
print_status "Installing Node.js dependencies..."
npm install --production

if [ $? -ne 0 ]; then
    print_error "Failed to install Node.js dependencies"
    exit 1
fi

# Step 3: Build assets for production
print_status "Building assets for production..."
npm run build

if [ $? -ne 0 ]; then
    print_error "Failed to build assets"
    exit 1
fi

# Step 4: Generate application key if not exists
if [ ! -f ".env" ]; then
    print_warning ".env file not found. Creating from .env.example..."
    cp .env.example .env
fi

print_status "Generating application key..."
php artisan key:generate --force

# Step 5: Clear and cache configurations
print_status "Clearing and caching configurations..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Step 6: Cache configurations for production
print_status "Caching configurations for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Step 7: Create storage link
print_status "Creating storage link..."
php artisan storage:link

# Step 8: Set proper permissions (if possible)
print_status "Setting file permissions..."
if [ -w "storage" ]; then
    chmod -R 755 storage
    chmod -R 755 bootstrap/cache
    chmod -R 755 public
    print_status "File permissions set successfully"
else
    print_warning "Could not set file permissions. Please set them manually:"
    echo "  chmod -R 755 storage"
    echo "  chmod -R 755 bootstrap/cache"
    echo "  chmod -R 755 public"
fi

# Step 9: Create deployment info file
print_status "Creating deployment information..."
cat > deployment-info.txt << EOF
OSR Digital Deployment Information
==================================

Build Date: $(date)
Build Version: $(git rev-parse --short HEAD 2>/dev/null || echo "unknown")
PHP Version: $(php -v | head -n 1)
Node Version: $(node --version 2>/dev/null || echo "unknown")
Laravel Version: $(php artisan --version)

Deployment Checklist:
- [ ] Upload all files to shared hosting
- [ ] Point document root to 'public' folder
- [ ] Configure .env file with production settings
- [ ] Set up database and run migrations
- [ ] Run: php artisan migrate --force
- [ ] Run: php artisan db:seed --force
- [ ] Set proper file permissions
- [ ] Test the application

Important Files to Upload:
- All files except: node_modules, .git, tests
- Ensure .env is configured for production
- Make sure public/build directory exists

Security Notes:
- Set APP_DEBUG=false in .env
- Set APP_ENV=production in .env
- Use strong database passwords
- Enable HTTPS/SSL

Support:
- Documentation: README.md
- Deployment Guide: SHARED_HOSTING_DEPLOYMENT.md
- Issues: Check storage/logs/laravel.log for errors
EOF

print_status "Deployment information saved to deployment-info.txt"

# Step 10: Create .gitignore for production
print_status "Creating production .gitignore..."
cat > .gitignore.production << EOF
# Production .gitignore
# Exclude development files from production deployment

# Dependencies
node_modules/
vendor/

# Development files
.env
.env.local
.env.development
.env.testing
.env.production

# Logs
storage/logs/*.log
*.log

# Cache
bootstrap/cache/*.php
storage/framework/cache/*
storage/framework/sessions/*
storage/framework/views/*

# IDE files
.vscode/
.idea/
*.swp
*.swo

# OS files
.DS_Store
Thumbs.db

# Git
.git/
.gitignore

# Build files (keep the built assets)
# public/build/ is needed for production

# Test files
tests/
phpunit.xml

# Development scripts
build-production.sh
deployment-info.txt
EOF

print_status "Production .gitignore created"

# Step 11: Summary
echo ""
print_status "🎉 Production build completed successfully!"
echo ""
print_status "Next steps:"
echo "1. Upload all files to your shared hosting (except excluded files)"
echo "2. Point your subdomain's document root to the 'public' folder"
echo "3. Configure your .env file with production settings"
echo "4. Set up your database and run migrations"
echo "5. Test your application"
echo ""
print_status "Files to exclude from upload:"
echo "- node_modules/"
echo "- .git/"
echo "- tests/"
echo "- .env (configure on server)"
echo "- storage/logs/ (will be created automatically)"
echo ""
print_status "Check deployment-info.txt for detailed instructions"
echo ""

# Step 12: Check if build directory exists
if [ -d "public/build" ]; then
    print_status "✅ Assets built successfully in public/build/"
else
    print_error "❌ Assets build failed - public/build/ directory not found"
    exit 1
fi

print_status "🚀 Ready for shared hosting deployment!"
