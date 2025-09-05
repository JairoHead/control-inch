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

# IMPORTANTE: Crear estructura de directorios ANTES del mount del volumen
RUN mkdir -p /app/storage/app/public \
    && mkdir -p /app/storage/logs \
    && mkdir -p /app/storage/framework/cache \
    && mkdir -p /app/storage/framework/sessions \
    && mkdir -p /app/storage/framework/views

# Configurar permisos
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Ejecutar comandos Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Crear symlink de storage (esto debe ejecutarse DESPUÉS del mount del volumen)
RUN php artisan storage:link || true

# Crear script de inicio que maneje el enlace simbólico después del mount
RUN echo '#!/bin/bash\n\
# Recrear enlace simbólico después del mount del volumen\n\
rm -f /app/public/storage\n\
php artisan storage:link\n\
# Iniciar supervisor\n\
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf' > /start.sh \
    && chmod +x /start.sh

# Exponer puerto
EXPOSE 8080

# Al final del Dockerfile, antes del CMD, agrega:
RUN echo "LOG_CHANNEL=single" >> /app/.env.production
RUN echo "LOG_LEVEL=debug" >> /app/.env.production

# Y permite logs de Laravel ir a stdout
RUN ln -sf /proc/1/fd/1 /app/storage/logs/laravel.log

# Usar script de inicio personalizado
CMD ["/start.sh"]



