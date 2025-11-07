#!/bin/bash
# Livewire Minified JS Fix Deployment Script

echo "🔧 Fixing Livewire minified JS issue..."

# 1. Publish Livewire assets
echo "📦 Publishing Livewire assets..."
php artisan livewire:publish --assets

# 2. Create directory if it doesn't exist
echo "📁 Creating livewire directory..."
mkdir -p public/livewire

# 3. Try to create symlink, fallback to copy if symlink fails
if [ -f "public/vendor/livewire/livewire.min.js" ]; then
    echo "🔗 Creating symlink..."
    ln -sf ../vendor/livewire/livewire.min.js public/livewire/livewire.min.js 2>/dev/null || {
        echo "⚠️  Symlink failed, copying file instead..."
        cp public/vendor/livewire/livewire.min.js public/livewire/livewire.min.js
    }
    echo "✅ File available at public/livewire/livewire.min.js"
else
    echo "❌ Error: public/vendor/livewire/livewire.min.js not found!"
    echo "   Run: php artisan livewire:publish --assets"
    exit 1
fi

# 4. Clear all caches
echo "🧹 Clearing caches..."
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 5. Rebuild route cache if needed (for production)
if [ "$APP_ENV" = "production" ]; then
    echo "🔨 Rebuilding route cache..."
    php artisan route:cache
    php artisan config:cache
fi

echo "✅ Deployment complete!"
echo ""
echo "📋 Verification:"
echo "   File exists: $(test -f public/livewire/livewire.min.js && echo 'YES' || echo 'NO')"
echo "   File size: $(du -h public/livewire/livewire.min.js 2>/dev/null | cut -f1 || echo 'N/A')"
echo ""
echo "🧪 Test the route:"
echo "   curl -I https://osrdigital.com.np/livewire/livewire.min.js?id=df3a17f2"
