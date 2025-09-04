# Etapa 1: Dependencias PHP y Composer
FROM php:8.2-fpm AS php-build

WORKDIR /app

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    unzip git curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring zip bcmath \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar archivos de Laravel
COPY . /app

# Instalar dependencias PHP
RUN composer install --optimize-autoloader --no-dev \
 && php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear \
 && php artisan storage:link

# Etapa 2: Node (para compilar assets)
FROM node:20 AS node-build

WORKDIR /app
COPY . /app
RUN npm ci && npm run build

# Etapa 3: Imagen final con PHP + Nginx
FROM php:8.2-fpm

WORKDIR /app

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    nginx supervisor \
    && rm -rf /var/lib/apt/lists/*

# Copiar PHP desde build
COPY --from=php-build /app /app

# Copiar assets compilados desde Node
COPY --from=node-build /app/public /app/public

# Configurar Nginx
COPY .docker/nginx.conf /etc/nginx/nginx.conf

# Configurar Supervisor para manejar Nginx y PHP-FPM
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Exponer puerto
EXPOSE 8080

# Comando de inicio
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
