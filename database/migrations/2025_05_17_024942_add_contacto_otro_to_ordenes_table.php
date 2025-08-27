<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_contacto_otro_to_ordenes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            // Después del campo 'contacto' existente
            $table->string('contacto_otro')->nullable()->after('contacto');
        });
    }

    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->dropColumn('contacto_otro');
        });
    }
};