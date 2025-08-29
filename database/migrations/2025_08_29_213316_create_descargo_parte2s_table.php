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
        Schema::create('descargo_parte2s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('descargo_tipo_id')->index('descargo_parte2s_descargo_tipo_id_foreign');
            $table->text('plantilla');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descargo_parte2s');
    }
};
