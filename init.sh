#!/bin/bash

mysqladmin drop dcms -u root --force
mysqladmin create dcms -u root

# Init PHPCR
./app/console doctrine:phpcr:init
# Init ORM
./app/console doctrine:schema:update --force

./app/console doctrine:phpcr:register-system-node-types
./app/console dcms:core:register-node-types --verbose
./app/console doctrine:phpcr:fixtures:load --no-interaction --verbose

