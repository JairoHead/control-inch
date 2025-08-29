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
            $table->foreign(['departamento_id'])->references(['id'])->on('ubigeo_departamentos')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['descargo_parte1_id_sel'])->references(['id'])->on('descargo_parte1s')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['descargo_parte2_id_sel'])->references(['id'])->on('descargo_parte2s')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['descargo_parte3_id_sel'])->references(['id'])->on('descargo_parte3s')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['descargo_tipo_id_sel'])->references(['id'])->on('descargo_tipos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['distrito_id'])->references(['id'])->on('ubigeo_distritos')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['cliente_id'], 'ordenes_ibfk_1')->references(['id'])->on('clientes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['inspector_id'], 'ordenes_ibfk_2')->references(['id'])->on('inspectores')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['provincia_id'])->references(['id'])->on('ubigeo_provincias')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->dropForeign('ordenes_departamento_id_foreign');
            $table->dropForeign('ordenes_descargo_parte1_id_sel_foreign');
            $table->dropForeign('ordenes_descargo_parte2_id_sel_foreign');
            $table->dropForeign('ordenes_descargo_parte3_id_sel_foreign');
            $table->dropForeign('ordenes_descargo_tipo_id_sel_foreign');
            $table->dropForeign('ordenes_distrito_id_foreign');
            $table->dropForeign('ordenes_ibfk_1');
            $table->dropForeign('ordenes_ibfk_2');
            $table->dropForeign('ordenes_provincia_id_foreign');
        });
    }
};
