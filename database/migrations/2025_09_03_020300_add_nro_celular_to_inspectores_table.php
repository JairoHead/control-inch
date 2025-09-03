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
        Schema::table('inspectores', function (Blueprint $table) {
            // Añadimos la nueva columna, nullable, después de 'apellido_materno'
            $table->string('nro_celular', 15)->nullable()->after('apellido_materno');
        });
    }

    public function down(): void
    {
        Schema::table('inspectores', function (Blueprint $table) {
            $table->dropColumn('nro_celular');
        });
    }
};
