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
        Schema::table('ubigeo_distritos', function (Blueprint $table) {
            $table->foreign(['departamento_id'])->references(['id'])->on('ubigeo_departamentos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['provincia_id'])->references(['id'])->on('ubigeo_provincias')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ubigeo_distritos', function (Blueprint $table) {
            $table->dropForeign('ubigeo_distritos_departamento_id_foreign');
            $table->dropForeign('ubigeo_distritos_provincia_id_foreign');
        });
    }
};
