<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB; // Asegúrate de importar DB
use Illuminate\Support\Facades\Log; // Para el Log en down()

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $newEnumValuesWithSuperscript = [
            '2x16+Pmm²', // Con superíndice
            '3x25+Pmm²',
            '3x35+Pmm²',
            '3x50+Pmm²',
            '3x70+Pmm²',
            '3x95+Pmm²',
            '3x25+2x16+Pmm²',
            '3x35+2x16+Pmm²',
            '3x50+2x16+Pmm²',
            '3x70+2x16+Pmm²',
            '3x95+2x16+Pmm²',
            'CONCENTRICO TRIPOLAR 6mm²',
            'CONCENTRICO TRIPOLAR 4mm²'
        ];
        $enumString = "'" . implode("','", $newEnumValuesWithSuperscript) . "'";

        // Asegúrate de que la definición de NULL/NOT NULL y DEFAULT sea la correcta para tu columna
        // Y añade CHARACTER SET y COLLATE para asegurar compatibilidad con el superíndice
        DB::statement("ALTER TABLE ordenes MODIFY COLUMN cable_matriz ENUM({$enumString}) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Lista de los valores ORIGINALES del ENUM (antes de este cambio con superíndice)
        // Estos son los que tenías ANTES de querer añadir el '²'
        $originalEnumValuesWithoutSuperscript = [
            '2x16+Pmm2',
            '3x25+Pmm2',
            '3x35+Pmm2',
            '3x50+Pmm2',
            '3x70+Pmm2',
            '3x95+Pmm2',
            '3x25+2x16+Pmm2',
            '3x35+2x16+Pmm2',
            '3x50+2x16+Pmm2',
            '3x70+2x16+Pmm2',
            '3x95+2x16+Pmm2',
            'CONCENTRICO TRIPOLAR 6mm2',
            'CONCENTRICO TRIPOLAR 4mm2'
        ];
        $enumStringOriginal = "'" . implode("','", $originalEnumValuesWithoutSuperscript) . "'";

        // Revertir a la definición anterior
        // Ajusta CHARACTER SET y COLLATE si eran diferentes en la definición original
        DB::statement("ALTER TABLE ordenes MODIFY COLUMN cable_matriz ENUM({$enumStringOriginal}) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        Log::info('Revertida la migración de cable_matriz a valores ENUM sin superíndice.');
    }
};