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
        Schema::table('descargo_parte3s', function (Blueprint $table) {
            $table->foreign(['descargo_tipo_id'])->references(['id'])->on('descargo_tipos')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('descargo_parte3s', function (Blueprint $table) {
            $table->dropForeign('descargo_parte3s_descargo_tipo_id_foreign');
        });
    }
};
