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
        Schema::table('ordenes', function (Blueprint $table) {
        // Ajusta el nombre de la columna si prefieres (ej. 'map_link', 'location_url')
        // La longitud de 255 debería ser suficiente, pero puedes poner más si quieres (ej. 500 o TEXT)
        $table->string('google_maps_link', 255)->nullable()->after('observacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
        $table->dropColumn('google_maps_link');
        });
    }
};
