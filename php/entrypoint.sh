#!/bin/bash

set -e

echo "Instalando dependências do projeto"
composer install
echo "Instalação concluída com sucesso!"

chmod -R 777 /var/log/
chmod -R 777 /var/www/storage
chmod -R 777 /var/www/public

exec "$@"