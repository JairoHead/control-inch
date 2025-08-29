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
        Schema::table('ubigeo_provincias', function (Blueprint $table) {
            $table->foreign(['departamento_id'])->references(['id'])->on('ubigeo_departamentos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ubigeo_provincias', function (Blueprint $table) {
            $table->dropForeign('ubigeo_provincias_departamento_id_foreign');
        });
    }
};
