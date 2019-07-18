
rm -rf var/cache/*

composer ezcommerce-install

php bin/console ezplatform:install ezcommerce_econtent_demo

php bin/console silversolutions:switchdataprovider econtent --location-id=118 --new-root-node=2

bin/console cache:clear

bin/console kaliop:migration:migrate --path migrations/kaliop_migrations/demo/demo.yml -v -n -u

bin/console ezplatform:reindex

bin/console silversolutions:indexecontent --live-core
