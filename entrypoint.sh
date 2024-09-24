#!/bin/bash

# Wait for PostgreSQL to be ready
until pg_isready -h "${DB_HOST}" -p "${DB_PORT}" -U "${DB_USERNAME}"; do
  echo "Waiting for PostgreSQL to be ready..."
  sleep 1
done

# Run migrations
php artisan migrate:refresh --seed 


# Start PHP-FPM service
exec "$@"
