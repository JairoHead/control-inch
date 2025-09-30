<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->boolean('req_caja_paso')->nullable()->change();
            $table->boolean('req_permiso_mun')->nullable()->change();
            $table->boolean('req_coord_entidad')->nullable()->change();
            $table->boolean('incumplimiento_dms')->nullable()->change();
            $table->boolean('tiene_nicho')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->enum('req_caja_paso', ['SI','NO'])->nullable()->change();
            $table->enum('req_permiso_mun', ['SI','NO'])->nullable()->change();
            $table->enum('req_coord_entidad', ['SI','NO'])->nullable()->change();
            $table->enum('incumplimiento_dms', ['SI','NO'])->nullable()->change();
            $table->enum('tiene_nicho', ['sí','no'])->nullable()->change();
        });
    }
};
