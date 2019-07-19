echo "> executing sh install-demo.sh"

rm -rf var/cache/*

php bin/console ezplatform:install ezcommerce_econtent_demo

bin/console cache:clear

bin/console kaliop:migration:migrate --path migrations/kaliop_migrations/demo/demo.yml -v -n -u

bin/console ezplatform:reindex

bin/console silversolutions:indexecontent --live-core

echo "install-demo.sh executed"
