<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // ...
    public function up(): void
    {
        Schema::create('foto_ordens', function (Blueprint $table) {
            $table->id();
            // ¡NO USAMOS foreignId()! Lo definimos manualmente.
            $table->integer('orden_id'); // INT(11) con signo
            $table->string('path');
            $table->string('caption')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_ordens');
    }
};
