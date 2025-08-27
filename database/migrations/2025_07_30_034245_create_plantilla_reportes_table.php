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
        Schema::create('plantilla_reportes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_descriptivo'); // Ej: "Reporte Sin Reforma Aérea"
            $table->enum('tipo_trabajo', ['PROYECTO', 'RUTINA']);
            // Relación con los tipos de descargo que ya creamos
            $table->foreignId('descargo_tipo_id')->constrained('descargo_tipos');
            // Nombre del archivo de la plantilla en la carpeta storage
            $table->string('nombre_archivo'); // Ej: "LCL 6300851661-MDE-19.9KW-CNX AÉREA-SIN REFORMA-CHANCAY.docx"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_reportes');
    }
};
