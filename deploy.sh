#!/bin/bash

# OSR Digital - Shared Hosting Deployment Script
# This script automates the deployment process for shared hosting

set -e

echo "🚀 Starting OSR Digital Deployment..."

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

# Step 1: Install/Update Composer Dependencies
echo -e "${YELLOW}Step 1: Installing Composer dependencies (production only)...${NC}"
composer install --no-dev --optimize-autoloader --no-interaction

# Step 2: Build Assets
echo -e "${YELLOW}Step 2: Building production assets...${NC}"
if [ -f "package.json" ]; then
    npm install --production=false
    npm run build
else
    echo -e "${YELLOW}No package.json found, skipping asset build...${NC}"
fi

# Step 3: Generate Application Key (if not exists)
echo -e "${YELLOW}Step 3: Checking application key...${NC}"
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    echo -e "${YELLOW}Generating application key...${NC}"
    php artisan key:generate --force
else
    echo -e "${GREEN}Application key already exists.${NC}"
fi

# Step 4: Run Migrations
echo -e "${YELLOW}Step 4: Running database migrations...${NC}"
read -p "Run migrations? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force
else
    echo -e "${YELLOW}Skipping migrations...${NC}"
fi

# Step 5: Setup Storage (without symlink for shared hosting)
echo -e "${YELLOW}Step 5: Setting up storage...${NC}"
if [ -z "$STORAGE_TYPE" ] || [ "$STORAGE_TYPE" = "copy" ]; then
    php artisan storage:setup-no-symlink --copy || echo -e "${YELLOW}Storage setup completed.${NC}"
else
    php artisan storage:link || echo -e "${YELLOW}Storage link may already exist.${NC}"
fi

# Step 6: Clear Caches
echo -e "${YELLOW}Step 6: Clearing all caches...${NC}"
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# Step 7: Optimize for Production
echo -e "${YELLOW}Step 7: Optimizing for production...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Step 8: Set Permissions
echo -e "${YELLOW}Step 8: Setting file permissions...${NC}"
chmod -R 755 storage bootstrap/cache 2>/dev/null || echo -e "${YELLOW}Could not set permissions (may need to do manually).${NC}"
chmod -R 755 public 2>/dev/null || echo -e "${YELLOW}Could not set permissions (may need to do manually).${NC}"

# Step 9: Optimize Autoloader
echo -e "${YELLOW}Step 9: Optimizing Composer autoloader...${NC}"
composer dump-autoload --optimize --classmap-authoritative

echo -e "${GREEN}✅ Deployment completed successfully!${NC}"
echo -e "${YELLOW}⚠️  Don't forget to:${NC}"
echo -e "   - Verify .env configuration"
echo -e "   - Check file permissions (storage, bootstrap/cache should be 755)"
echo -e "   - Test the application"
echo -e "   - Set APP_DEBUG=false in production"

