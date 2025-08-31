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
        // Renombramos la tabla de 'reportes_generados' (plural) a 'reporte_generados' (singular)
        Schema::rename('reportes_generados', 'reporte_generados');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Esto permite revertir el cambio si es necesario
        Schema::rename('reporte_generados', 'reportes_generados');
    }
};