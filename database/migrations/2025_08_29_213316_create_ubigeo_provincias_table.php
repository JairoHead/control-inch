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
        Schema::create('ubigeo_provincias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provincia', 100);
            $table->string('ubigeo', 4);
            $table->unsignedBigInteger('departamento_id')->index('ubigeo_provincias_departamento_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubigeo_provincias');
    }
};
