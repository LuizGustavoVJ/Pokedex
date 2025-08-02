#!/bin/sh

# Limpar cache
echo "Limpando cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Otimizar para produção
echo "Otimizando para produção..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar serviços
echo "Iniciando serviços..."
php-fpm -D
nginx -g "daemon off;"
