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
    Schema::table('plantilla_reportes', function (Blueprint $table) {
        // Primero, eliminamos la clave foránea si existe
        $table->dropForeign(['descargo_tipo_id']);
        // Luego, eliminamos la columna
        $table->dropColumn('descargo_tipo_id');
    });
}

public function down(): void // Para poder revertir
{
    Schema::table('plantilla_reportes', function (Blueprint $table) {
        $table->foreignId('descargo_tipo_id')->nullable()->constrained('descargo_tipos');
    });
}
};
