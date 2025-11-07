#!/bin/bash

# Livewire Deployment Script for Shared Hosting
# Fixes CSP issues and ensures Livewire assets are properly deployed

set -e

echo "🚀 Starting Livewire Deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: artisan file not found. Please run this script from the Laravel root directory.${NC}"
    exit 1
fi

# Step 1: Publish Livewire Assets
echo -e "${YELLOW}Step 1: Publishing Livewire assets...${NC}"
php artisan livewire:publish --assets

# Step 2: Ensure Livewire directory exists
echo -e "${YELLOW}Step 2: Creating Livewire public directory...${NC}"
mkdir -p public/livewire
mkdir -p public/vendor/livewire

# Step 3: Verify Livewire assets exist
if [ -f "public/vendor/livewire/livewire.min.js" ]; then
    echo -e "${GREEN}✅ Livewire assets found${NC}"
else
    echo -e "${RED}❌ Error: Livewire assets not found!${NC}"
    echo -e "${YELLOW}   Trying to publish again...${NC}"
    php artisan livewire:publish --assets
fi

# Step 4: Regenerate Composer Autoloader
echo -e "${YELLOW}Step 3: Regenerating Composer autoloader...${NC}"
composer dump-autoload --optimize --classmap-authoritative

# Step 5: Clear All Laravel Caches
echo -e "${YELLOW}Step 4: Clearing all Laravel caches...${NC}"
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# Step 6: Optimize for Production
echo -e "${YELLOW}Step 5: Optimizing for production...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Step 7: Set Permissions
echo -e "${YELLOW}Step 6: Setting file permissions...${NC}"
chmod -R 755 storage bootstrap/cache 2>/dev/null || echo -e "${YELLOW}⚠️  Could not set permissions (may need to do manually).${NC}"
chmod -R 755 public/vendor 2>/dev/null || echo -e "${YELLOW}⚠️  Could not set permissions (may need to do manually).${NC}"

echo -e "${GREEN}✅ Livewire deployment completed successfully!${NC}"
echo ""
echo -e "${YELLOW}📋 Verification:${NC}"
echo -e "   Livewire JS: $(test -f public/vendor/livewire/livewire.min.js && echo '✅ EXISTS' || echo '❌ MISSING')"
echo -e "   File size: $(du -h public/vendor/livewire/livewire.min.js 2>/dev/null | cut -f1 || echo 'N/A')"
echo ""
echo -e "${YELLOW}🧪 Test URLs:${NC}"
echo -e "   HTTPS: https://osrdigital.com.np/vendor/livewire/livewire.min.js"
echo -e "   Make sure APP_URL=https://osrdigital.com.np in .env"

