#!/bin/bash

until php artisan migrate --force; do
  echo "Waiting for database to be ready..."
  sleep 3
done

php artisan config:cache

exec apache2-foreground
