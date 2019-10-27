#!/usr/bin/env bash
#docker-compose -p msa up --build
docker-compose -p msa down
docker-compose -p msa up -d
docker exec -ti php_base sh -c "composer update"
docker exec -ti php_auth sh -c "composer update"
docker exec -ti php_finance sh -c "composer update"
docker exec -ti php_elastic sh -c "composer update"

docker exec -ti php_base sh -c "php bin/console doctrine:database:create"
docker exec -ti php_auth sh -c "php bin/console doctrine:database:create"
docker exec -ti php_finance sh -c "php bin/console doctrine:database:create"
docker exec -ti php_elastic sh -c "php bin/console doctrine:database:create"
docker exec -ti php_elastic sh -c "php bin/console doctrine:schema:update --force"
docker exec -ti php_elastic sh -c "php bin/console fos:elastica:populate"