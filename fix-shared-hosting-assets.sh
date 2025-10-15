#!/bin/bash

echo "🔧 Fixing Shared Hosting Asset Issues"
echo "====================================="

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Not in Laravel project directory"
    exit 1
fi

echo "✅ Laravel project detected"

# Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Rebuild assets
echo "🏗️  Rebuilding assets..."
npm run build

# Check if assets were built
if [ ! -d "public/build/assets" ]; then
    echo "❌ Error: Assets not built properly"
    exit 1
fi

echo "✅ Assets built successfully"

# Set correct permissions
echo "🔐 Setting permissions..."
chmod -R 755 public/build
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Check asset files
echo "📁 Checking asset files..."
asset_count=$(find public/build/assets -name "*.js" | wc -l)
echo "JavaScript files: $asset_count"

css_count=$(find public/build/assets -name "*.css" | wc -l)
echo "CSS files: $css_count"

# Test asset URLs
echo "🌐 Testing asset URLs..."
base_url="https://osr.codebundles.com"
test_assets=(
    "build/assets/icons-BNKDixbA.js"
    "build/assets/vendor-Bzgz95E1.js"
    "build/assets/Home-Ch6gPf9a.js"
)

for asset in "${test_assets[@]}"; do
    url="$base_url/$asset"
    echo "Testing: $url"
    if curl -s -I "$url" | grep -q "200 OK"; then
        echo "✅ $asset - OK"
    else
        echo "❌ $asset - FAILED"
    fi
done

echo ""
echo "🎉 Asset fix completed!"
echo ""
echo "📋 Next steps:"
echo "1. Upload the entire project to your shared hosting"
echo "2. Make sure the document root points to the 'public' directory"
echo "3. Set up your .env file with correct database credentials"
echo "4. Run: php artisan migrate:fresh --seed"
echo "5. Test the application"
echo ""
echo "🔍 If assets still don't work:"
echo "1. Check that document root points to 'public' directory"
echo "2. Verify .htaccess is in the public directory"
echo "3. Check server error logs"
echo "4. Test with: https://osr.codebundles.com/test-assets.php"
