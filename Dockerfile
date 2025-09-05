FROM php:8.2-fpm
# Reemplaza el script de inicio con este:
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
echo "=== Iniciando aplicación Laravel ==="\n\
\n\
# Limpiar cachés\n\
php artisan config:clear || true\n\
php artisan route:clear || true\n\
php artisan view:clear || true\n\
\n\
# Verificar y crear directorios necesarios\n\
mkdir -p /app/storage/app/public\n\
mkdir -p /app/storage/logs\n\
mkdir -p /app/storage/framework/cache/data\n\
mkdir -p /app/storage/framework/sessions\n\
mkdir -p /app/storage/framework/views\n\
mkdir -p /app/bootstrap/cache\n\
\n\
# Configurar permisos DESPUÉS de crear directorios\n\
chown -R www-data:www-data /app/storage /app/bootstrap/cache\n\
chmod -R 775 /app/storage /app/bootstrap/cache\n\
\n\
# Recrear cachés (después de permisos)\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
# Crear enlace simbólico correctamente\n\
rm -f /app/public/storage\n\
php artisan storage:link\n\
\n\
echo "=== Verificando configuración ==="\n\
echo "Enlace storage: $(ls -la /app/public/storage)"\n\
echo "Directorio storage/app/public: $(ls -la /app/storage/app/public || echo no existe)"\n\
\n\
echo "=== Configuración completada ==="\n\
\n\
# Iniciar supervisor\n\
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf' > /start.sh \
    && chmod +x /start.sh