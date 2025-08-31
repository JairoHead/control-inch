<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Paso 1: Actualizar todos los valores existentes en 'llave_cable' a NULL (o a uno de los valores ENUM válidos si prefieres)
        // Esto es para evitar el error "Data truncated"
        DB::table('ordenes')->update(['llave_cable' => null]);

        // Paso 2: Definir los nuevos valores ENUM
        $enumValues = [
            'CABLE AL. NA2XY 0.6/1KV. 1-1x 70',
            'CABLE AL. NA2XY 0.6/1KV. 1-1x150',
            'CABLE AL. NA2XY 0.6/1KV. 1-1x240',
            'CABLE AL. NA2XY 0.6/1KV. 1-1x400',
        ];
        $enumString = "'" . implode("','", array_map('addslashes', $enumValues)) . "'";

        // Paso 3: Modificar la columna a ENUM
        DB::statement("ALTER TABLE ordenes MODIFY COLUMN llave_cable ENUM({$enumString}) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir la columna al tipo VARCHAR(100) nullable
        // Es importante tener el paquete doctrine/dbal: composer require doctrine/dbal
        Schema::table('ordenes', function (Blueprint $table) {
            $table->string('llave_cable', 100)->nullable()->default(null)->change();
        });
        // Nota: Al hacer rollback, los datos que eran ENUM válidos se mantendrán como strings.
        // Los datos que pusimos a NULL seguirán siendo NULL.
    }
};