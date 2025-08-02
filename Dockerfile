# Dockerfile para Laravel + Vue.js

# Estágio 1: Build do Frontend
FROM node:18-alpine AS frontend-build

WORKDIR /app

# Copiar arquivos de dependências do frontend
COPY package*.json ./
COPY vite.config.js ./

# Instalar dependências do frontend
RUN npm ci

# Copiar código fonte do frontend
COPY resources/js ./resources/js
COPY resources/css ./resources/css

# Build do frontend
RUN npm run build

# Estágio 2: Build do Backend
FROM php:8.2-fpm-alpine AS backend-build

# Instalar dependências do sistema
RUN apk add --no-cache \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-install \
    zip \
    mbstring

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar arquivos do projeto
COPY . .

# Instalar dependências do PHP
RUN composer install --optimize-autoloader

# Copiar build do frontend
COPY --from=frontend-build /app/public/build ./public/build

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Estágio 3: Imagem final
FROM php:8.2-fpm-alpine

# Instalar dependências do sistema
RUN apk add --no-cache \
    libzip-dev \
    oniguruma-dev \
    nginx \
    && docker-php-ext-install \
    zip \
    mbstring

# Copiar configuração do Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Copiar aplicação do estágio anterior
COPY --from=backend-build /var/www/html /var/www/html

# Configurar Nginx
RUN mkdir -p /run/nginx

# Expor porta
EXPOSE 80

# Script de inicialização
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
