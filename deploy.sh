#!/bin/bash
# Lakeshore Clinic - Hostinger Deployment Script
# Run this script to create a deployment ZIP for Hostinger

echo "========================================="
echo "  Lakeshore Clinic - Hostinger Deployer"
echo "========================================="
echo ""

# Build assets
echo "[1/4] Building production assets..."
npm run build
if [ $? -ne 0 ]; then
    echo "Error: Asset build failed!"
    exit 1
fi
echo "Assets built successfully!"
echo ""

# Create deployment directory
echo "[2/4] Preparing deployment package..."
DEPLOY_DIR="hostinger-deploy"
rm -rf $DEPLOY_DIR
mkdir -p $DEPLOY_DIR

# Copy Laravel files
echo "Copying Laravel files..."
cp -r app $DEPLOY_DIR/
cp -r bootstrap $DEPLOY_DIR/
cp -r config $DEPLOY_DIR/
cp -r database $DEPLOY_DIR/
cp -r resources $DEPLOY_DIR/
cp -r routes $DEPLOY_DIR/
cp -r vendor $DEPLOY_DIR/
cp artisan $DEPLOY_DIR/
cp composer.json $DEPLOY_DIR/
cp composer.lock $DEPLOY_DIR/

# Copy public files (these go to public_html root)
echo "Copying public files..."
mkdir -p $DEPLOY_DIR/public_html
cp -r public/* $DEPLOY_DIR/public_html/

# Copy storage (with empty directories preserved)
echo "Setting up storage..."
mkdir -p $DEPLOY_DIR/storage/app/private
mkdir -p $DEPLOY_DIR/storage/app/public
mkdir -p $DEPLOY_DIR/storage/app/uploads
mkdir -p $DEPLOY_DIR/storage/framework/cache
mkdir -p $DEPLOY_DIR/storage/framework/sessions
mkdir -p $DEPLOY_DIR/storage/framework/views
mkdir -p $DEPLOY_DIR/storage/logs

# Set permissions
chmod -R 755 $DEPLOY_DIR/storage
chmod -R 755 $DEPLOY_DIR/bootstrap/cache

# Copy environment file
echo "[3/4] Setting up environment..."
cp .env.production $DEPLOY_DIR/.env
echo "NOTE: Edit .env file with your database credentials!"
echo ""

# Create root index.php for Hostinger
cat > $DEPLOY_DIR/public_html/index.php << 'ROOTPHP'
<?php
/**
 * Lakeshore Clinic - Hostinger Root Index
 *
 * This file routes requests to Laravel's public/index.php
 */

// Laravel is in the parent directory
$laravelPath = dirname(__DIR__);

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode
if (file_exists($maintenance = $laravelPath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader
require $laravelPath . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request
$app = require_once $laravelPath . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();
ROOTPHP

# Create .htaccess for public_html
cat > $DEPLOY_DIR/public_html/.htaccess << 'HTACCESS'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Prevent directory listing
Options -Indexes
HTACCESS

# Create ZIP
echo "[4/4] Creating deployment ZIP..."
cd $DEPLOY_DIR
zip -r ../hostinger-deploy.zip . -x "*.DS_Store" "*Thumbs.db"
cd ..

echo ""
echo "========================================="
echo "  Deployment Package Ready!"
echo "========================================="
echo ""
echo "ZIP File: hostinger-deploy.zip"
echo ""
echo "UPLOAD INSTRUCTIONS:"
echo "1. Login to Hostinger hPanel"
echo "2. Go to Files → File Manager"
echo "3. Navigate to /home/USERNAME/"
echo "4. Upload hostinger-deploy.zip"
echo "5. Extract the ZIP"
echo "6. Move contents of 'public_html' folder to /public_html/"
echo "7. Move remaining Laravel folders to /laravel-app/"
echo "8. Edit .env with database credentials"
echo "9. Run: php artisan key:generate"
echo "10. Run: php artisan migrate --force"
echo ""
echo "See DEPLOYMENT.md for detailed instructions!"
echo ""
