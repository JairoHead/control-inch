<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Orden; // <-- ¡IMPORTANTE! Importa tu modelo Orden

return new class extends Migration
{
    /**
     * Run the migrations.
     * Añade la columna 'estado' a la tabla 'ordenes'.
     */
    public function up(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            // Añade la columna 'estado' de tipo string
            // Establece el valor por defecto usando la constante del modelo
            // Colócala después de la columna 'cliente_id' (puedes cambiar 'cliente_id' por otra columna si prefieres)
            $table->string('estado')
                  ->default(Orden::ESTADO_PENDIENTE) // Usa la constante para el estado por defecto
                  ->after('cliente_id') // Posiciona la columna (ajusta si es necesario)
                  ->comment('Estado actual de la orden (pendiente, en_campo, post_campo, completada, cancelada)'); // Comentario opcional
        });
    }

    /**
     * Reverse the migrations.
     * Elimina la columna 'estado' de la tabla 'ordenes'.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            // Verifica si la columna existe antes de intentar eliminarla (buena práctica)
            if (Schema::hasColumn('ordenes', 'estado')) {
                $table->dropColumn('estado');
            }
        });
    }
};