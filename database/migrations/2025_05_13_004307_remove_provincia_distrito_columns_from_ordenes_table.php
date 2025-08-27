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
            // Asegúrate que las columnas realmente existen antes de intentar borrarlas
            if (Schema::hasColumn('ordenes', 'provincia')) {
                $table->dropColumn('provincia');
            }
            if (Schema::hasColumn('ordenes', 'distrito')) {
                $table->dropColumn('distrito');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            // Define cómo revertir si es necesario (añadir las columnas de nuevo)
            // Ajusta el tipo si era diferente, y considera dónde ponerlas (after())
            $table->string('provincia')->nullable()->after('suministro_existente'); // Ajusta el tipo y 'after' si es necesario
            $table->string('distrito')->nullable()->after('provincia'); // Ajusta el tipo y 'after' si es necesario
        });
    }
};