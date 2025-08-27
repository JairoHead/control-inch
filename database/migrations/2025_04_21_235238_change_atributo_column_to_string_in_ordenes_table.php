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
            $table->string('atributo', 10)->nullable()->change();
        });
        
        // down() - Revertir al tipo anterior (ajusta si era diferente)
        // Schema::table('ordenes', function (Blueprint $table) {
        //     $table->enum('atributo', ['...'])->nullable()->change(); // O el tipo que fuera
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
