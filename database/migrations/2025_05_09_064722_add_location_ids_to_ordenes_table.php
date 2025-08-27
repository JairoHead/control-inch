<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   

    // database/migrations/..._add_location_ids_to_ordenes_table.php
    public function up(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            // Añadir después de alguna columna existente, ej. 'nombre_contacto'
            $table->foreignId('departamento_id')->nullable()->after('nombre_contacto')->constrained('ubigeo_departamentos')->onDelete('set null');
            $table->foreignId('provincia_id')->nullable()->after('departamento_id')->constrained('ubigeo_provincias')->onDelete('set null');
            $table->foreignId('distrito_id')->nullable()->after('provincia_id')->constrained('ubigeo_distritos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            // Importante dropear en orden inverso o dropear clave foránea primero
            $table->dropForeign(['distrito_id']);
            $table->dropColumn('distrito_id');
            $table->dropForeign(['provincia_id']);
            $table->dropColumn('provincia_id');
            $table->dropForeign(['departamento_id']);
            $table->dropColumn('departamento_id');
        });
    }
};
