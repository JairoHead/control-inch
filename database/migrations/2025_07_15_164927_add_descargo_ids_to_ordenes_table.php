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
        Schema::table('ordenes', function (Blueprint $table) {
            // Guardamos el ID del TIPO de descargo seleccionado
            $table->foreignId('descargo_tipo_id_sel')->nullable()->constrained('descargo_tipos')->after('descripcion_trabajo');
            // Guardamos el ID de la PLANTILLA de la parte 1
            $table->foreignId('descargo_parte1_id_sel')->nullable()->constrained('descargo_parte1s')->after('descargo_tipo_id_sel');
            // ...y así para las otras partes
            $table->foreignId('descargo_parte2_id_sel')->nullable()->constrained('descargo_parte2s')->after('descargo_parte1_id_sel');
            $table->foreignId('descargo_parte3_id_sel')->nullable()->constrained('descargo_parte3s')->after('descargo_parte2_id_sel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            //
        });
    }
};
