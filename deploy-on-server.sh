#!/bin/bash

# OSR Digital Server Deployment Script
# Run this script on your shared hosting server after uploading files

echo "🚀 Starting OSR Digital Server Deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

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

# Check if .env exists
if [ ! -f ".env" ]; then
    print_error ".env file not found. Please create it first with your production settings."
    exit 1
fi

# Step 1: Generate application key
print_status "Generating application key..."
php artisan key:generate --force

# Step 2: Clear caches
print_status "Clearing application caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Step 3: Run migrations
print_status "Running database migrations..."
php artisan migrate --force

if [ $? -ne 0 ]; then
    print_error "Migration failed. Please check your database configuration."
    exit 1
fi

# Step 4: Seed database
print_status "Seeding database with initial data..."
php artisan db:seed --force

# Step 5: Create storage link
print_status "Creating storage link..."
php artisan storage:link

# Step 6: Cache configurations for production
print_status "Caching configurations for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Step 7: Set file permissions
print_status "Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 755 public

# Step 8: Test basic functionality
print_status "Testing basic functionality..."
if php artisan --version > /dev/null 2>&1; then
    print_status "✅ Laravel is working correctly"
else
    print_error "❌ Laravel installation has issues"
    exit 1
fi

# Step 9: Check if assets exist
if [ -d "public/build" ]; then
    print_status "✅ Assets found in public/build/"
else
    print_warning "⚠️  Assets not found. Make sure to run 'npm run build' before deployment."
fi

# Step 10: Final status
print_status "🎉 Deployment completed successfully!"
echo ""
print_status "Next steps:"
echo "1. Test your website in a browser"
echo "2. Check the admin panel at /admin"
echo "3. Login with: admin@osrdigital.com / password"
echo "4. Change the default admin password"
echo "5. Configure your site settings"
echo ""
print_status "If you encounter any issues:"
echo "1. Check storage/logs/laravel.log for errors"
echo "2. Verify file permissions"
echo "3. Check your .env configuration"
echo "4. Ensure your database is accessible"
echo ""

# Display hosting information
print_status "Hosting Information:"
echo "Environment: $(php artisan env:get APP_ENV 2>/dev/null || echo 'unknown')"
echo "Debug Mode: $(php artisan env:get APP_DEBUG 2>/dev/null || echo 'unknown')"
echo "App URL: $(php artisan env:get APP_URL 2>/dev/null || echo 'unknown')"
echo "PHP Version: $(php -v | head -n 1)"
echo "Laravel Version: $(php artisan --version)"
