#!/bin/bash
set -x
cd "$(dirname "$0")";
#php bin/console doctrine:database:drop --force
#php bin/console doctrine:database:create
#php bin/console doctrine:schema:update --force --dump-sql
#php bin/console doctrine:query:sql "SET GLOBAL foreign_key_checks=0"
#php bin/console doctrine:fixtures:load --purge-with-truncate --no-interaction
#php bin/console doctrine:query:sql "SET GLOBAL foreign_key_checks=1"
php bin/console app:generar-ubicaciones-elsalvador
#php bin/console admin:generar-clientes-prueba 500
#php bin/console admin:generar-medicos-prueba 500
#php bin/console admin:enlazar-usuarios 1 6 50
set +x