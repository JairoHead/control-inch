<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reportes_generados', function (Blueprint $table) {
            $table->id(); // Crea BIGINT UNSIGNED, está bien para la PK de esta tabla.

            // --- CAMBIO CLAVE ---
            // Definimos la columna 'orden_id' manualmente para que coincida con ordenes.id
            $table->integer('orden_id'); // Esto crea un INT(11) con signo.

            // Para las otras claves foráneas, foreignId() funciona porque sus tablas usan BIGINT UNSIGNED
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plantilla_reporte_id')->constrained('plantilla_reportes')->onDelete('cascade');
            
            $table->string('nombre_archivo_generado');
            $table->timestamps();

            // Definimos la relación para 'orden_id' por separado
            $table->foreign('orden_id')->references('id')->on('ordenes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_generados');
    }
};
