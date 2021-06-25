SECRETS_FILE="$1"
LARAVEL_ROOT="/var/www/dhpid-search"
ENV_FILE="${LARAVEL_ROOT}/.env"

if [ ! -f "${SECRETS_FILE}" ]; then
    echo "Unable to locate ${SECRETS_FILE}"
    exit 1
else
    . "${SECRETS_FILE}"
fi

cp "${LARAVEL_ROOT}/.env.example" "${ENV_FILE}"

# Setup DB TLS for Azure environment
sed -i 's/^DB_SSLMODE=.*$/DB_SSLMODE=require/' "${ENV_FILE}"
sed -i 's/^DB_STRICT=.*$/DB_STRICT=false/' "${ENV_FILE}"
sed -i 's/^DB_SSL_CAFILE=.*$/DB_SSL_CAFILE=${DB_CAFILE}/' "${ENV_FILE}"

# Setup AHR connection
sed -i 's/^DB_HOST=.*$/DB_HOST=${DB_HOST}/' "${ENV_FILE}"
sed -i 's/^DB_USERNAME=.*$/DB_USERNAME=${DB_USER}/' "${ENV_FILE}"
sed -i 's/^DB_PASSWORD=.*$/DB_PASSWORD=${DB_PASS}/' "${ENV_FILE}"
sed -i 's/^DB_DATABASE=.*$/DB_DATABASE=${DB_AHR}/' "${ENV_FILE}"

# Setup CTO connection
sed -i 's/^DB_HOST_CTO=.*$/DB_HOST_CTO=${DB_HOST}/' "${ENV_FILE}"
sed -i 's/^DB_USERNAME_CTO=.*$/DB_USERNAME_CTO=${DB_USER}/' "${ENV_FILE}"
sed -i 's/^DB_PASSWORD_CTO=.*$/DB_PASSWORD_CTO=${DB_PASS}/' "${ENV_FILE}"
sed -i 's/^DB_DATABASE_CTO=.*$/DB_DATABASE_CTO=${DB_CTO}/' "${ENV_FILE}"

# Setup CTA connection
sed -i 's/^DB_HOST_CTA=.*$/DB_HOST_CTA=${DB_HOST}/' "${ENV_FILE}"
sed -i 's/^DB_USERNAME_CTA=.*$/DB_USERNAME_CTA=${DB_USER}/' "${ENV_FILE}"
sed -i 's/^DB_PASSWORD_CTA=.*$/DB_PASSWORD_CTA=${DB_PASS}/' "${ENV_FILE}"
sed -i 's/^DB_DATABASE_CTA=.*$/DB_DATABASE_CTA=${DB_CTA}/' "${ENV_FILE}"

cd "${LARAVEL_ROOT}"

# Set Laravel filesystem permissions
chgrp -R www-data "${LARAVEL_ROOT}"
chmod 0440 "${ENV_FILE}"
touch "${LARAVEL_ROOT}/storage/logs/laravel.log"
chmod g+w "${LARAVEL_ROOT}/storage/logs/laravel.log"
chown -R www-data "${LARAVEL_ROOT}/storage/framework/cache"
chown -R www-data "${LARAVEL_ROOT}/storage/framework/sessions"
chown -R www-data "${LARAVEL_ROOT}/storage/framework/views"

# This can only be executed after the .env file has been setup with the appropriate credentials:
php artisan key:generate ; php artisan config:cache

# Laravel "migrations" create the database schema
# Laravel "seeders" inject reference table data
php artisan migrate:fresh --database='ahr' --path=database/migrations/AHR ; php artisan db:seed --class=AHRDatabaseSeeder
php artisan migrate:fresh --database='cto' --path=database/migrations/CTO ; php artisan db:seed --class=CTODatabaseSeeder
php artisan migrate:fresh --database='cta' --path=database/migrations/CTA ; php artisan db:seed --class=CTADatabaseSeeder
