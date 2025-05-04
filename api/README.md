# api_focomotor
## Build Setup

```bash
### install dependencies
composer install

### serve at 192.168.0.186
php artisan serve --port=8080 --host=192.168.0.186


# Migrate database
php artisan migrate

# Seeders
php artisan db:seed

php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=FuelSeeder
php artisan db:seed --class=ImageSeeder
php artisan db:seed --class=LocationSeeder
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=VehicleSeeder
php artisan db:seed --class=WordpressSeeder
php artisan db:seed --class=DatabaseResetSeeder

# Storage link
php artisan storage:link

cd public
# Windows:
mklink /D storage C:\www\focomotor\api\storage\app
# Linux:
ln -s /home/focomotor-api/htdocs/api.focomotor.com.ar/storage/app storage

# Dirs error
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data

# Cache
php artisan config:cache
php artisan cache:clear

# Dependencies
composer require tymon/jwt-auth
php artisan jwt:secret

# Cron Jobs
php artisan schedule:run
php artisan vehicles:delete-expired 
curl https://api.focomotor.com.ar/api/delete-exipired-vehicles

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

mklink /D ".\public\storage" ".\storage\app\public"
mklink /D ".\public\storage" ".\storage\app\public"
ln -s ./storage/app/public ./public/storage

# Storage link
php artisan storage:link
public/storage → storage/app/public
mkdir -p storage/app/public
chmod -R 775 storage
chown -R www-data:www-data storage bootstrap/cache
rm public/storage  # Remove broken link
php artisan storage:link
