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
            // Determinar después de qué columna existente añadir los nuevos campos.
            // Usaremos 'descripcion_trabajo' como referencia, ajusta si es otra.
            $lastKnownField = 'descripcion_trabajo';

            // Campos de LLAVE
            $table->string('llave_base_fus', 100)->nullable()->after($lastKnownField);
            $table->string('llave_fusible', 100)->nullable()->after('llave_base_fus');
            $table->string('llave_cable', 100)->nullable()->after('llave_fusible');
            $table->string('llave_in', 100)->nullable()->after('llave_cable');
            $table->string('llave_iadm', 100)->nullable()->after('llave_in');
            // Campos numéricos para cálculo de Llave
            $table->decimal('llave_ir_valor', 8, 2)->nullable()->after('llave_iadm'); // 8 dígitos en total, 2 decimales
            $table->decimal('llave_ic_valor', 8, 2)->nullable()->after('llave_ir_valor');
            $table->decimal('llave_ip_valor', 8, 2)->nullable()->after('llave_ic_valor'); // Resultado calculado

            // Campo para el código de la segunda tabla (TRAFO)
            // Asumimos que el campo 'llave' (para el número de llave como "01") ya existe.
            // Si no, añádelo también: $table->string('llave', 50)->nullable()->after('llave_ip_valor');
            $table->string('codigo_trafo', 50)->nullable()->after('llave_ip_valor');

            // Campos de TRAFO
            $table->string('trafo_pta', 100)->nullable()->after('codigo_trafo');
            $table->string('trafo_vr', 100)->nullable()->after('trafo_pta'); // Vr no se calcula, así que puede ser string
            // Campos numéricos para cálculo de Trafo
            $table->decimal('trafo_dmr_valor', 8, 2)->nullable()->after('trafo_vr');
            $table->decimal('trafo_lc_valor', 8, 2)->nullable()->after('trafo_dmr_valor');
            $table->decimal('trafo_dmp_valor', 8, 2)->nullable()->after('trafo_lc_valor'); // Resultado calculado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->dropColumn([
                'llave_base_fus',
                'llave_fusible',
                'llave_cable',
                'llave_in',
                'llave_iadm',
                'llave_ir_valor',
                'llave_ic_valor',
                'llave_ip_valor',
                'codigo_trafo',
                'trafo_pta',
                'trafo_vr',
                'trafo_dmr_valor',
                'trafo_lc_valor',
                'trafo_dmp_valor',
            ]);
        });
    }
};