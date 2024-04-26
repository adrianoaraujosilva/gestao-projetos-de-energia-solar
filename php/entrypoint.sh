#!/bin/bash

set -e

echo "Instalando dependências do projeto"
composer install
echo "Instalação concluída com sucesso!"

# chmod -R 777 /var/log/
# chmod -R 777 /var/www/storage
# chmod -R 777 /var/www/public

echo "Criando tabelas"
php /var/www/artisan migrate
echo "Tabelas criadas com sucesso!"

echo "Populando tabelas"
php /var/www/artisan db:seed
echo "Tabelas populadas com sucesso!"

# echo "Publicando tradução"
# php artisan vendor:publish --tag=laravel-pt-br-localization

exec "$@"
