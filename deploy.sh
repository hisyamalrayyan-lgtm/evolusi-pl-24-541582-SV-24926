#!/bin/bash
set -e

echo "Step 1: Pull latest code from repository"
git pull origin main

echo "Step 2: Install/update Composer dependencies"
composer install --no-dev --optimize-autoloader

echo "Step 3: Run database migrations"
php artisan migrate --force

echo "Step 4: Clear and cache application config"
php artisan config:cache

echo "Step 5: Clear and cache routes"
php artisan route:cache

echo "Step 6: Clear and cache views"
php artisan view:cache

echo "Step 7: Restart queue workers and reload services"
php artisan queue:restart

echo "Deploy complete!"
