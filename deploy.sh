#!/bin/bash

# Laravel Cloud Deployment Script
# Add this to your deployment process

echo "Creating storage link..."
php artisan storage:link

echo "Clearing caches..."
php artisan optimize:clear

echo "Testing storage configuration..."
php artisan storage:test

echo "Deployment complete!"
