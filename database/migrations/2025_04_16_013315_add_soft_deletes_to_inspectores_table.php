<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inspectores', function (Blueprint $table) {
            $table->softDeletes(); // Añade deleted_at
        });
    }

    public function down(): void
    {
        Schema::table('inspectores', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Elimina deleted_at
        });
    }
};