#!/bin/sh

echo "Starting new Application ..."

echo "re-migrating database ..."
php artisan migrate:fresh

echo "clearing cache ..."
php artisan cache:clear

echo "creating access tokens"
php artisan passport:install

echo "creating default user..."
php artisan create:user

echo "user created"
echo "user's email: timothy33.tf@gmail.com"
echo "user's password: secret"