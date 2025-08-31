<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            // Cambia a VARCHAR permitiendo NULL temporalmente
            $table->string('contrato', 100)->nullable()->change();
        });

        // Opcional: si necesitas que sea NOT NULL al final y estás seguro
        // de que no hay NULLs después del cambio y limpieza:
        // Schema::table('ordenes', function (Blueprint $table) {
        //     $table->string('contrato', 100)->nullable(false)->change();
        // });
    }

    public function down(): void
    {
         // Revertir al ENUM original permitiendo NULL si antes lo hacía
         // Nota: Revertir ENUMs puede ser problemático. Asegúrate de los valores.
         Schema::table('ordenes', function (Blueprint $table) {
             $table->enum('contrato', ['N.C.', 'APPLUS'])->nullable()->change(); // Asume que permitía NULL antes
         });
    }
};