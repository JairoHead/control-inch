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
        Schema::create('ubigeo_distritos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('distrito', 150);
            $table->string('ubigeo', 6);
            $table->unsignedBigInteger('provincia_id')->index('ubigeo_distritos_provincia_id_foreign');
            $table->unsignedBigInteger('departamento_id')->index('ubigeo_distritos_departamento_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubigeo_distritos');
    }
};
