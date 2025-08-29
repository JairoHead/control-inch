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
        Schema::table('reporte_generados', function (Blueprint $table) {
            $table->foreign(['orden_id'], 'reportes_generados_orden_id_foreign')->references(['id'])->on('ordenes')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['plantilla_reporte_id'], 'reportes_generados_plantilla_reporte_id_foreign')->references(['id'])->on('plantilla_reportes')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['user_id'], 'reportes_generados_user_id_foreign')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reporte_generados', function (Blueprint $table) {
            $table->dropForeign('reportes_generados_orden_id_foreign');
            $table->dropForeign('reportes_generados_plantilla_reporte_id_foreign');
            $table->dropForeign('reportes_generados_user_id_foreign');
        });
    }
};
