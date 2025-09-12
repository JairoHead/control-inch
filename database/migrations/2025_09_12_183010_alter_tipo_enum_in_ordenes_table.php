<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE ordenes 
            MODIFY COLUMN tipo ENUM('NUEVO SUMINISTRO', 'INCREMENTO', 'TRASLADO', 'CNX MULTIPLE', 'AFECTACION') 
            NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE ordenes 
            MODIFY COLUMN tipo ENUM('NUEVO SUMINISTRO', 'INCREMENTO', 'TRASLADO') 
            NULL");
    }
};
