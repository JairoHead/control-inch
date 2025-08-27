<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_distprediopasaje_cp_to_ordenes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            // Decide dónde quieres que aparezcan estas columnas,
            // usar ->after('nombre_columna_existente')
            // Por ejemplo, después de los otros campos de distancia de la fase "Durante"
            $table->string('dist_predio_pasaje')->nullable()->after('dist_predio_pto_venta'); // Distancia Predio a Pasaje
            $table->string('cp')->nullable()->after('dist_predio_pasaje'); // Centro Poblado
        });
    }

    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->dropColumn(['dist_predio_pasaje', 'cp']);
        });
    }
};