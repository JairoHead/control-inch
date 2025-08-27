<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; 
use Illuminate\Database\Eloquent\Casts\Attribute; 
use Illuminate\Contracts\Filesystem\Filesystem;

class Orden extends Model
{
    use HasFactory; // Asumo que también tienes SoftDeletes si lo usas en otros modelos

    // --- Constantes para los Estados ---
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_EN_CAMPO = 'en_campo';
    const ESTADO_POST_CAMPO = 'post_campo';
    const ESTADO_COMPLETADA = 'completada';
    const ESTADO_CANCELADA = 'cancelada';

    protected $table = 'ordenes';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'estado',

        // Campos Fase "Antes"
        'contrato', 'num_insp', 'fecha_insp', 'inspector_id', 'tipo_registro',
        'lcl', 'ov', 'cliente_id', 'direccion_servicio_electrico', 'nro_solicitud',
        'nro_cuenta_suministro', 'cc', 'sistema_acometida', 'tension', 'tarifa',
        'tipo', 'suministro_aledaño', 'referencia', 'sed', 'alimentador',
        'departamento_id', 'provincia_id', 'distrito_id', 'atributo', 'nombre_contacto', 'google_maps_link',

        // Campos Fase "Durante"
        'tipo_trabajo', 'pago_proyecto', 'ancho_pasaje', 'num_poste',
        'dist_murete_pto_venta', 'dist_predio_pto_venta', 'dist_predio_pasaje', 'cp',
        'suministro_existente', 'tipo_acometida', 'ubicacion_medidor',
        'req_caja_paso', 'req_permiso_mun', 'req_coord_entidad', 'incumplimiento_dms',
        'uso_servicio', 'contacto', 'contacto_otro', 'tiene_nicho', 'observacion', 'cantidad_suministros',

        // Campos Fase "Despues"
        'fecha_drive_satel', 'fecha_scm',
        'llave', // Este es el número/código de la llave, ej: "01"
        'cable_matriz', // Se mantiene como campo separado
        'predio_dentro_conc_elect', 'predio_zona_arqueologica',
        'descripcion_trabajo', 'descargo_tipo_id_sel', 'descargo_parte1_id_sel', 
        'descargo_parte2_id_sel', 'descargo_parte3_id_sel',

        // NUEVOS CAMPOS DE LLAVE (Fase Despues)
        'llave_base_fus',
        'llave_fusible',
        'llave_cable', // Información específica de la tabla LLAVE
        'llave_in',
        'llave_iadm',
        'llave_ir_valor',
        'llave_ic_valor',
        'llave_ip_valor',   // Calculado

        // NUEVOS CAMPOS DE TRAFO (Fase Despues)
        'codigo_trafo',     // Para el "05692C"
        'trafo_pta',
        'trafo_vr',
        'trafo_dmr_valor',
        'trafo_lc_valor',
        'trafo_dmp_valor',  // Calculado
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'fecha_insp' => 'date',
        'fecha_drive_satel' => 'date',
        'fecha_scm' => 'date',

        // Booleans de Fase Durante
        'tiene_nicho' => 'boolean',
        'req_caja_paso' => 'boolean',
        'req_permiso_mun' => 'boolean',
        'req_coord_entidad' => 'boolean',
        'incumplimiento_dms' => 'boolean',

        // Booleans de Fase Despues
        'predio_dentro_conc_elect' => 'boolean',
        'predio_zona_arqueologica' => 'boolean',

        // Casts para los nuevos campos numéricos de Fase Despues
        'llave_ir_valor' => 'float',
        'llave_ic_valor' => 'float',
        'llave_ip_valor' => 'float',
        'trafo_dmr_valor' => 'float',
        'trafo_lc_valor' => 'float',
        'trafo_dmp_valor' => 'float',
    ];

    // --- Relaciones ---
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function inspector()
    {
        return $this->belongsTo(Inspector::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

     public function fotos()
    {
        // Una orden tiene muchas FotoOrden
        return $this->hasMany(FotoOrden::class);
    }

    public function reportesGenerados()
    {
        return $this->hasMany(ReporteGenerado::class);
    }

    // --- Helpers de Estado ---
    public function estaPendiente() { return $this->estado === self::ESTADO_PENDIENTE; }
    public function estaEnCampo() { return $this->estado === self::ESTADO_EN_CAMPO; }
    public function estaEnPostCampo() { return $this->estado === self::ESTADO_POST_CAMPO; }
    public function estaCompletada() { return $this->estado === self::ESTADO_COMPLETADA; }
    public function estaCancelada() { return $this->estado === self::ESTADO_CANCELADA; }

    public function esEditable() {
        return in_array($this->estado, [
            self::ESTADO_PENDIENTE,
            self::ESTADO_EN_CAMPO,
            self::ESTADO_POST_CAMPO
        ]);
    }

   

    // --- Accesors ---
    public function getEstadoLegibleAttribute() { // CORREGIDO: $this->estado
        switch ($this->estado) {
            case self::ESTADO_PENDIENTE: return 'Pendiente';
            case self::ESTADO_EN_CAMPO: return 'En Campo'; // CORREGIDO: self::
            case self::ESTADO_POST_CAMPO: return 'Post-Campo'; // CORREGIDO: self::
            case self::ESTADO_COMPLETADA: return 'Completada'; // CORREGIDO: self::
            case self::ESTADO_CANCELADA: return 'Cancelada'; // CORREGIDO: self::
            default: return ucfirst($this->estado ?? 'Desconocido');
        }
    }

}