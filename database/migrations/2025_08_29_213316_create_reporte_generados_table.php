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
        Schema::create('reporte_generados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('orden_id')->index('reportes_generados_orden_id_foreign');
            $table->unsignedBigInteger('user_id')->index('reportes_generados_user_id_foreign');
            $table->unsignedBigInteger('plantilla_reporte_id')->index('reportes_generados_plantilla_reporte_id_foreign');
            $table->string('nombre_archivo_generado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_generados');
    }
};
