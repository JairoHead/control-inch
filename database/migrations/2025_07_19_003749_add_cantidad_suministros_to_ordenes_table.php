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
            // Añadimos la nueva columna.
            // Puede ser un integer o un string, dependiendo de lo que necesites.
            // La colocamos después de una columna existente para mantener el orden.
            $table->integer('cantidad_suministros')->nullable()->after('cp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            // Esto permite revertir la migración de forma segura
            $table->dropColumn('cantidad_suministros');
        });
    }
};