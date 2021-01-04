#!/bin/bash

echo "`date +'%Y-%m-%d %T %N'`: After Install" >> /root/deployment.log
# Copy the production environment file from S3 to the local installation
aws s3 cp s3://sonicsales-serverconfig/.env /var/www/snapshot/.env

# Install composer dependencies
sudo composer install --no-ansi --no-dev --no-suggest --no-interaction --no-progress --prefer-dist --no-scripts -d /var/www/snapshot

# Setup the various file and folder permissions for Laravel
sudo touch /var/www/snapshot/storage/logs/laravel.log
sudo chown -R ubuntu:www-data /var/www/snapshot
sudo find /var/www/snapshot -type d -exec chmod 755 {} +
sudo find /var/www/snapshot -type f -exec chmod 644 {} +
sudo chgrp -R www-data /var/www/snapshot/storage /var/www/snapshot/bootstrap/cache
sudo chmod -R ug+rwx /var/www/snapshot/storage /var/www/snapshot/bootstrap/cache

# Clear any previous cached views and optimize the application
php /var/www/snapshot/artisan cache:clear
php /var/www/snapshot/artisan view:clear
php /var/www/snapshot/artisan config:cache
php /var/www/snapshot/artisan optimize
php /var/www/snapshot/artisan route:cache

php /var/www/snapshot/artisan migrate --force

# Refresh public symlink
rm -rf /var/www/html
ln -s /var/www/snapshot/public /var/www/html


echo "`date +'%Y-%m-%d %T %N'`: Finished" >> /root/deployment.log