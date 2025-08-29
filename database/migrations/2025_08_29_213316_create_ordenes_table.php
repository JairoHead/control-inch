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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('contrato', 100)->nullable();
            $table->enum('num_insp', ['1', '2', '3'])->nullable();
            $table->enum('tipo_trabajo', ['PROYECTO', 'RUTINA'])->nullable();
            $table->string('pago_proyecto', 30)->nullable();
            $table->date('fecha_insp')->nullable();
            $table->date('fecha_drive_satel')->nullable();
            $table->date('fecha_scm')->nullable();
            $table->integer('inspector_id')->nullable()->index('inspector_id');
            $table->enum('tipo_registro', ['NORMAL', 'ACTUALIZACIÓN'])->nullable();
            $table->string('lcl')->nullable();
            $table->string('ov')->nullable();
            $table->integer('cliente_id')->nullable()->index('cliente_id');
            $table->string('estado')->default('pendiente')->comment('Estado actual de la orden (pendiente, en_campo, post_campo, completada, cancelada)');
            $table->string('nro_solicitud')->nullable();
            $table->string('nro_cuenta_suministro')->nullable();
            $table->float('cc')->nullable();
            $table->integer('sistema_acometida')->nullable();
            $table->string('tension')->nullable();
            $table->string('tarifa')->nullable();
            $table->enum('tipo', ['NUEVO SUMINISTRO', 'INCREMENTO', 'TRASLADO'])->nullable();
            $table->string('suministro_aledaño')->nullable();
            $table->string('referencia')->nullable();
            $table->enum('llave', ['1', '2', '3'])->nullable();
            $table->string('sed')->nullable();
            $table->string('alimentador')->nullable();
            $table->enum('cable_matriz', ['2x16+Pmm²', '3x25+Pmm²', '3x35+Pmm²', '3x50+Pmm²', '3x70+Pmm²', '3x95+Pmm²', '3x25+2x16+Pmm²', '3x35+2x16+Pmm²', '3x50+2x16+Pmm²', '3x70+2x16+Pmm²', '3x95+2x16+Pmm²', 'CONCENTRICO TRIPOLAR 6mm²', 'CONCENTRICO TRIPOLAR 4mm²'])->nullable();
            $table->float('ancho_pasaje')->nullable();
            $table->string('num_poste')->nullable();
            $table->float('dist_murete_pto_venta')->nullable();
            $table->float('dist_predio_pto_venta')->nullable();
            $table->string('dist_predio_pasaje')->nullable();
            $table->string('cp')->nullable();
            $table->integer('cantidad_suministros')->nullable();
            $table->string('suministro_existente')->nullable();
            $table->string('direccion_servicio_electrico')->nullable();
            $table->enum('tipo_acometida', ['Aérea', 'Subterránea'])->nullable();
            $table->enum('ubicacion_medidor', ['Fachada', 'Murete'])->nullable();
            $table->enum('req_caja_paso', ['SI', 'NO'])->nullable();
            $table->enum('req_permiso_mun', ['SI', 'NO'])->nullable();
            $table->enum('predio_dentro_conc_elect', ['SI', 'NO'])->nullable();
            $table->enum('req_coord_entidad', ['SI', 'NO'])->nullable();
            $table->enum('predio_zona_arqueologica', ['SI', 'NO'])->nullable();
            $table->enum('incumplimiento_dms', ['SI', 'NO'])->nullable();
            $table->enum('uso_servicio', ['Doméstico', 'Comercial', 'Alumbrado Público', 'Educación', 'Estructura Metálica', 'Industria Ligera', 'Taller Mecánica'])->nullable();
            $table->string('contacto')->nullable();
            $table->string('contacto_otro')->nullable();
            $table->string('atributo', 10)->nullable();
            $table->string('nombre_contacto')->nullable();
            $table->unsignedBigInteger('departamento_id')->nullable()->index('ordenes_departamento_id_foreign');
            $table->unsignedBigInteger('provincia_id')->nullable()->index('ordenes_provincia_id_foreign');
            $table->unsignedBigInteger('distrito_id')->nullable()->index('ordenes_distrito_id_foreign');
            $table->enum('tiene_nicho', ['sí', 'no'])->nullable();
            $table->text('descripcion_trabajo')->nullable();
            $table->string('llave_base_fus', 100)->nullable();
            $table->string('llave_fusible', 100)->nullable();
            $table->enum('llave_cable', ['CABLE AL. NA2XY 0.6/1KV. 1-1x 70', 'CABLE AL. NA2XY 0.6/1KV. 1-1x150', 'CABLE AL. NA2XY 0.6/1KV. 1-1x240', 'CABLE AL. NA2XY 0.6/1KV. 1-1x400'])->nullable();
            $table->string('llave_in', 100)->nullable();
            $table->string('llave_iadm', 100)->nullable();
            $table->decimal('llave_ir_valor')->nullable();
            $table->decimal('llave_ic_valor')->nullable();
            $table->decimal('llave_ip_valor')->nullable();
            $table->string('codigo_trafo', 50)->nullable();
            $table->string('trafo_pta', 100)->nullable();
            $table->string('trafo_vr', 100)->nullable();
            $table->decimal('trafo_dmr_valor')->nullable();
            $table->decimal('trafo_lc_valor')->nullable();
            $table->decimal('trafo_dmp_valor')->nullable();
            $table->text('observacion')->nullable();
            $table->string('google_maps_link')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->unsignedBigInteger('descargo_tipo_id_sel')->nullable()->index('ordenes_descargo_tipo_id_sel_foreign');
            $table->unsignedBigInteger('descargo_parte1_id_sel')->nullable()->index('ordenes_descargo_parte1_id_sel_foreign');
            $table->unsignedBigInteger('descargo_parte2_id_sel')->nullable()->index('ordenes_descargo_parte2_id_sel_foreign');
            $table->unsignedBigInteger('descargo_parte3_id_sel')->nullable()->index('ordenes_descargo_parte3_id_sel_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
