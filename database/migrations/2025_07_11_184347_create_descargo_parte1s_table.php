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
        Schema::create('descargo_parte1s', function (Blueprint $table) {
            $table->id();
            // Relación con la tabla de tipos
            $table->foreignId('descargo_tipo_id')->constrained()->onDelete('cascade');
            $table->text('plantilla'); // El texto de la opción
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descargo_parte1s');
    }
};
