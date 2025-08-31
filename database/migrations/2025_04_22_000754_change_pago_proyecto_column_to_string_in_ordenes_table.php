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
            // Cambia a VARCHAR permitiendo NULL
            $table->string('pago_proyecto', 30)->nullable()->change(); // Ajusta longitud si es necesario
        });
        
        // down() - Revertir al tipo anterior
        // Schema::table('ordenes', function (Blueprint $table) {
        //     $table->integer('pago_proyecto')->nullable()->change(); // O el tipo que fuera
        // });
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
