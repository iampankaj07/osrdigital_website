#!/bin/bash

# Laravel Cloud Deployment Script
# This script ensures proper configuration for file storage and logos

echo "🚀 Starting Laravel Cloud deployment configuration..."

# Create storage link if it doesn't exist
echo "📁 Creating storage link..."
php artisan storage:link

# Clear all caches
echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions for storage directories
echo "🔐 Setting storage permissions..."
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Test storage configuration
echo "🧪 Testing storage configuration..."
php artisan storage:test

# Display environment info
echo "🌍 Environment Information:"
echo "APP_ENV: ${APP_ENV:-not set}"
echo "APP_URL: ${APP_URL:-not set}"
echo "FILESYSTEM_DISK: ${FILESYSTEM_DISK:-not set}"

# Check if public disk is accessible
if [ -L "public/storage" ]; then
    echo "✅ Storage link exists"
else
    echo "❌ Storage link missing - attempting to create..."
    php artisan storage:link
fi

# Check for logos directory
if [ -d "storage/app/public/logos" ]; then
    echo "✅ Logos directory exists"
    echo "📊 Logo files found:"
    ls -la storage/app/public/logos/ | head -10
else
    echo "📁 Creating logos directory..."
    mkdir -p storage/app/public/logos
    chmod 775 storage/app/public/logos
fi

echo "✅ Cloud deployment configuration complete!"
echo ""
echo "🔍 Next steps:"
echo "1. Verify APP_URL is correctly set in environment"
echo "2. Test logo upload functionality in admin panel"
echo "3. Check frontend logo display"
