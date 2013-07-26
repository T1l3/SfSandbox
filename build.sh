#!/bin/sh
# MyApplication build script

php composer.phar install --dev

# create database if not exists
php app/console doctrine:database:create --quiet --env=${1:-dev}

php app/console doctrine:schema:drop --force --env=${1:-dev}
php app/console doctrine:schema:update --force --env=${1:-dev}

php app/console doctrine:fixtures:load  --no-interaction --env=${1:-dev}

php app/console cache:clear --env=test --env=${1:-dev}
php app/console cache:warmup --env=test --env=${1:-dev}

bower install