#!/bin/bash

LARAVEL_ROOT="/var/www/dhpid-search"
ENV_FILE="${LARAVEL_ROOT}/.env"

# Check if already installed
if [ ! -f "${ENV_FILE}" ]; then
  # Check for required variables
  if [ -z "${DB_CAFILE}" ] || [ -z "${DB_USER}" ] || [ -z "${DB_PASS}" ] || [ -z "${DB_HOST}" ] || [ -z "${DB_AHR}" ] || [ -z "${DB_CTO}" ] || [ -z "${DB_CTA}" ]; then
    echo "ERROR: Missing variables. Please source the secrets file before running $0"
    exit 1
  fi

  echo "$0: Laravel '.env' not yet configured and variables OK. Configuring Laravel..."

  cp "${LARAVEL_ROOT}/.env.example" "${ENV_FILE}"

  # Setup DB TLS for Azure environment
  sed -i "s/^DB_SSLMODE=.*\$/DB_SSLMODE=require/" "${ENV_FILE}"
  sed -i "s/^DB_STRICT=.*\$/DB_STRICT=false/" "${ENV_FILE}"
  sed -i "s/^DB_SSL_CAFILE=.*\$/DB_SSL_CAFILE=${DB_CAFILE}/" "${ENV_FILE}"

  # Setup AHR connection
  sed -i "s/^DB_HOST=.*\$/DB_HOST=${DB_HOST}/" "${ENV_FILE}"
  sed -i "s/^DB_USERNAME=.*\$/DB_USERNAME=${DB_USER}/" "${ENV_FILE}"
  sed -i "s/^DB_PASSWORD=.*\$/DB_PASSWORD=${DB_PASS}/" "${ENV_FILE}"
  sed -i "s/^DB_DATABASE=.*\$/DB_DATABASE=${DB_AHR}/" "${ENV_FILE}"

  # Setup CTO connection
  sed -i "s/^DB_HOST_CTO=.*\$/DB_HOST_CTO=${DB_HOST}/" "${ENV_FILE}"
  sed -i "s/^DB_USERNAME_CTO=.*\$/DB_USERNAME_CTO=${DB_USER}/" "${ENV_FILE}"
  sed -i "s/^DB_PASSWORD_CTO=.*\$/DB_PASSWORD_CTO=${DB_PASS}/" "${ENV_FILE}"
  sed -i "s/^DB_DATABASE_CTO=.*\$/DB_DATABASE_CTO=${DB_CTO}/" "${ENV_FILE}"

  # Setup CTA connection
  sed -i "s/^DB_HOST_CTA=.*\$/DB_HOST_CTA=${DB_HOST}/" "${ENV_FILE}"
  sed -i "s/^DB_USERNAME_CTA=.*\$/DB_USERNAME_CTA=${DB_USER}/" "${ENV_FILE}"
  sed -i "s/^DB_PASSWORD_CTA=.*\$/DB_PASSWORD_CTA=${DB_PASS}/" "${ENV_FILE}"
  sed -i "s/^DB_DATABASE_CTA=.*\$/DB_DATABASE_CTA=${DB_CTA}/" "${ENV_FILE}"

  cd "${LARAVEL_ROOT}"

  # Set Laravel filesystem permissions
  chmod 0440 "${ENV_FILE}"
  touch "${LARAVEL_ROOT}/storage/logs/laravel.log"
  chmod g+w "${LARAVEL_ROOT}/storage/logs/laravel.log"
  chown -R www-data "${LARAVEL_ROOT}/storage/framework/cache"
  chown -R www-data "${LARAVEL_ROOT}/storage/framework/sessions"
  chown -R www-data "${LARAVEL_ROOT}/storage/framework/views"
  chgrp -R www-data "${LARAVEL_ROOT}"

  # This can only be executed after the .env file has been setup with the appropriate credentials:
  php artisan key:generate ; php artisan config:cache
fi

# Ensure apache is running
/usr/sbin/apache2ctl -DFOREGROUND
