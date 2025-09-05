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
RUN composer install --optimize-autoloader --no-dev

# Etapa 2: Node (para compilar assets)
FROM node:20 AS node-build

WORKDIR /app
COPY . /app
RUN npm ci && npm run build

# Etapa 3: Imagen final con PHP + Nginx
FROM php:8.2-fpm

WORKDIR /app

# Instalar dependencias del sistema Y las extensiones PHP
RUN apt-get update && apt-get install -y \
    nginx supervisor unzip git curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring zip bcmath \
    && rm -rf /var/lib/apt/lists/*

# Copiar aplicación desde build
COPY --from=php-build /app /app

# Copiar assets compilados desde Node
COPY --from=node-build /app/public/build /app/public/build

# PUBLICAR ASSETS DE LIVEWIRE
# Esto copiará los archivos JS y CSS de Livewire a public/vendor/livewire
RUN php artisan livewire:publish --assets

# Configurar Nginx y Supervisor
COPY .docker/nginx.conf /etc/nginx/nginx.conf
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Crear estructura de directorios
RUN mkdir -p /app/storage/app/public \
    && mkdir -p /app/storage/logs \
    && mkdir -p /app/storage/framework/cache \
    && mkdir -p /app/storage/framework/sessions \
    && mkdir -p /app/storage/framework/views \
    && mkdir -p /app/bootstrap/cache

# Configurar permisos
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Crear script de inicio que maneje todo correctamente
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
echo "=== Iniciando aplicación Laravel ==="\n\
\n\
# Limpiar cachés\n\
php artisan config:clear || true\n\
php artisan cache:clear || true\n\
php artisan route:clear || true\n\
php artisan view:clear || true\n\
\n\
# Recrear cachés\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
# Crear enlace simbólico\n\
rm -f /app/public/storage\n\
php artisan storage:link\n\
\n\
# Verificar permisos\n\
chown -R www-data:www-data /app/storage /app/bootstrap/cache\n\
chmod -R 775 /app/storage /app/bootstrap/cache\n\
\n\
echo "=== Configuración completada ==="\n\
\n\
# Iniciar supervisor\n\
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf' > /start.sh \
    && chmod +x /start.sh

# Exponer puerto
EXPOSE 8080

# Usar script de inicio personalizado
CMD ["/start.sh"]