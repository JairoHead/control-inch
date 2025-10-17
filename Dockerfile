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

# Configurar Nginx y Supervisor
COPY .docker/nginx.conf /etc/nginx/nginx.conf
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY .docker/php-fpm.conf /usr/local/etc/php-fpm.d/zz-custom.conf

# Crear estructura de directorios
RUN mkdir -p /app/storage/app/public \
    && mkdir -p /app/storage/logs \
    && mkdir -p /app/storage/framework/cache \
    && mkdir -p /app/storage/framework/sessions \
    && mkdir -p /app/storage/framework/views \
    && mkdir -p /app/bootstrap/cache \
    && mkdir -p /app/public/livewire

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
# Publicar assets de Livewire con más robustez\n\
php artisan livewire:publish --assets || echo "WARNING: Failed to publish Livewire assets"\n\
php artisan vendor:publish --tag=livewire:assets || echo "Alternative Livewire publish failed"\n\
\n\
# Recrear cachés\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
# Crear enlace simbólico para storage (con ruta absoluta)\n\
rm -f /app/public/storage\n\
ln -sfn /app/storage/app/public /app/public/storage || echo "WARNING: Failed to create storage link"\n\
\n\
# Verificar que el enlace se creó\n\
if [ -L /app/public/storage ]; then\n\
    echo "✓ Storage link created successfully"\n\
else\n\
    echo "✗ Storage link failed, creating directory structure"\n\
    mkdir -p /app/public/storage/uploads\n\
fi\n\
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