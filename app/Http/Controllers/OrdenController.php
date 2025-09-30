<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Cliente;
use App\Models\Inspector;
use App\Models\Departamento; // Se usa en editFaseAntes
use App\Models\DescargoTipo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrdenController extends Controller
{
    /**
     * Muestra una lista de las órdenes.
     */
    public function index()
    {
        $ordenes = Orden::with(['cliente', 'inspector']) // Carga relaciones comunes para la lista
                        ->latest()
                        ->paginate(15);
        return view('ordenes.index', compact('ordenes'));
    }

    /**
     * Muestra el formulario para la creación inicial de una orden.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('apellido_paterno')->orderBy('apellido_materno')->orderBy('nombres')->get();
        $inspectores = Inspector::orderBy('apellido_paterno')->orderBy('apellido_materno')->orderBy('nombres')->get();
        return view('ordenes.create', compact('clientes', 'inspectores'));
    }

    /**
     * Almacena el registro inicial de una nueva orden y redirige a la edición de la fase "Antes".
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'inspector_id' => 'required|exists:inspectores,id',
        ]);

        try {
            $orden = Orden::create($validatedData + ['estado' => Orden::ESTADO_PENDIENTE]);
            Log::info("Orden inicial #{$orden->id} creada para cliente ID {$request->cliente_id} por inspector ID {$request->inspector_id}.");

            return redirect()->route('ordenes.edit.antes', $orden)
                             ->with('success', 'Orden iniciada. Por favor, completa los datos de planificación (Fase Antes).');

        } catch (\Illuminate\Database\QueryException $e) {
             Log::error("Error de BD al crear orden inicial: " . $e->getMessage(), ['sql_error_code' => $e->getCode(), 'request_data' => $request->except('password', '_token')]);
             return back()->withInput()->with('error', 'Error al guardar la orden. Por favor, verifica los datos e inténtalo de nuevo.');
        } catch (\Exception $e) {
            Log::error("Error inesperado al crear orden inicial: " . $e->getMessage(), ['exception_trace' => substr($e->getTraceAsString(), 0, 2000), 'request_data' => $request->except('password', '_token')]);
            return back()->withInput()->with('error', 'Ocurrió un error inesperado al crear la orden. Inténtalo más tarde.');
        }
    }

    /**
     * Muestra los detalles de una orden específica.
     */
    public function show(Orden $orden)
    {
        // Cargar todas las relaciones necesarias para la vista 'show'
        // El Route Model Binding ya nos da $orden, pero la volvemos a cargar con 'with'
        // para asegurar que las relaciones están optimizadas y actualizadas.
        $ordenConRelaciones = Orden::with([
            'cliente',
            'inspector',
            'departamento',
            'provincia',
            'distrito'
        ])->findOrFail($orden->getKey()); // Usa getKey() para la clave primaria

        // Puedes mantener un log simple si quieres rastrear accesos a esta vista
        // Log::info("Mostrando detalles para Orden #{$ordenConRelaciones->id}");

        return view('ordenes.show', ['orden' => $ordenConRelaciones]);
    }

    /**
     * Muestra el formulario para editar la fase "Antes" de una orden.
     */
    public function editFaseAntes(Orden $orden)
    {
        $orden->loadMissing(['cliente', 'inspector']); // Carga si no están ya cargadas
        $clientes = Cliente::orderBy('apellido_paterno')->orderBy('apellido_materno')->orderBy('nombres')->get();
        $inspectores = Inspector::orderBy('apellido_paterno')->orderBy('apellido_materno')->orderBy('nombres')->get();
        // Asume que el modelo Departamento tiene accesor 'nombre' y '$appends' configurado
        $departamentos = Departamento::orderBy('departamento')->get();
        return view('ordenes.edit-antes', compact('orden', 'clientes', 'inspectores', 'departamentos'));
    }

    /**
     * Muestra el formulario para editar la fase "Durante" de una orden.
     */
    public function editFaseDurante(Orden $orden) // Asegúrate que este método exista
    {
        $orden->loadMissing(['cliente', 'inspector']);
        return view('ordenes.edit-durante', compact('orden'));
    }

    /**
     * Muestra el formulario para editar la fase "Después" de una orden.
     */
    public function editFaseDespues(Orden $orden)
    {
        $orden->loadMissing(['cliente', 'inspector']);
        // Aquí podrías cargar datos adicionales necesarios para la fase "Después"

         // Cargamos TODOS los tipos de descargo de la BD
        $tiposDeDescargo = DescargoTipo::orderBy('nombre')->get();
        // Pasamos la orden Y los tipos a la vista
        return view('ordenes.edit-despues', compact('orden', 'tiposDeDescargo'));
    
    }

    /**
     * Actualiza una orden basada en la acción recibida.
     */
    // En OrdenController.php

    public function update(Request $request, Orden $orden)
    {
        // ***** INICIO BLOQUE DE DEBUG *****
        // Pon este bloque aquí, al puro inicio del método, para ver qué llega ANTES de cualquier lógica.
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            Log::debug('DETALLES DEL ARCHIVO RECIBIDO (AL INICIO DEL UPDATE):', [
                'ACCION_FORMULARIO' => $request->input('action'),
                'NOMBRE_ORIGINAL' => $file->getClientOriginalName(),
                'EXTENSION_CLIENTE' => $file->getClientOriginalExtension(),
                'TAMAÑO_BYTES' => $file->getSize(),
                'MIME_TYPE_DETECTADO' => $file->getMimeType(), // <-- ¡CLAVE!
                'ES_VALIDO_PHP' => $file->isValid(),
                'CODIGO_ERROR_PHP' => $file->getError(),
                'GUESS_EXTENSION' => $file->guessExtension(),
                'GUESS_CLIENT_EXTENSION' => $file->guessClientExtension()
            ]);
        } else if ($request->input('action') === 'guardar_durante' || $request->input('action') === 'finalizar_campo') {
            Log::debug('INTENTO DE GUARDAR FASE DURANTE SIN ARCHIVO (AL INICIO DEL UPDATE):', [
                'ACCION_FORMULARIO' => $request->input('action'),
                'TIENE_CAMPO_PHOTO_EN_REQUEST_DATA' => $request->exists('photo'),
                'VALOR_CAMPO_PHOTO' => $request->input('photo')
                
            ]);
        }
        // ***** FIN BLOQUE DE DEBUG *****

        $action = $request->input('action');
        $rules = [];
        $validatedData = [];
        $newState = null;
        $successMessage = 'Orden actualizada exitosamente.';

        if ($action === 'remove_photo') {
            // ... (tu lógica de remove_photo) ...
            if ($orden->photo_path && Storage::disk('public')->exists($orden->photo_path)) {
                try {
                    Storage::disk('public')->delete($orden->photo_path);
                    $orden->photo_path = null;
                    $orden->save();
                    Log::info("Foto eliminada para Orden #{$orden->id}.");
                    return redirect()->route('ordenes.edit.durante', $orden)->with('success', 'Foto eliminada exitosamente.');
                } catch (\Exception $e) {
                    Log::error("Error al eliminar foto de Orden #{$orden->id}: " . $e->getMessage());
                    return back()->with('error', 'Error al eliminar la foto.');
                }
            }
            return redirect()->route('ordenes.edit.durante', $orden)->with('info', 'No había foto para eliminar.');
        }

        switch ($action) {
           case 'guardar_antes':
            case 'iniciar_campo':
                $rules = [
                    'contrato' => ['required', 'string', Rule::in(['Nuevo Contrato', 'AppLuz'])],
                    'num_insp' => ['required', 'integer', 'in:1,2'],
                    'fecha_insp' => ['nullable', 'date'],
                    'inspector_id' => ['required', 'exists:inspectores,id'],
                    'tipo_registro' => ['nullable', 'string', Rule::in(['NORMAL', 'ACTUALIZACION'])],
                    'lcl' => ['nullable', 'string', 'max:10'],
                    'ov' => ['nullable', 'string', 'max:7'],
                    'cliente_id' => ['required', 'exists:clientes,id'],
                    'direccion_servicio_electrico' => ['nullable', 'string', 'max:500'],
                    'nro_solicitud' => ['nullable', 'string', 'max:7'],
                    'nro_cuenta_suministro' => ['nullable', 'string', 'max:7'],
                    'cc' => ['nullable', 'string', 'max:100'],
                    'sistema_acometida' => ['nullable', 'string', Rule::in(['1', '2', '3'])],
                    'tension' => ['nullable', 'string', 'max:50'],
                    'tarifa' => ['nullable', 'string', 'max:50'],
                    'tipo' => ['nullable', 'string', Rule::in(['NUEVO SUMINISTRO', 'INCREMENTO', 'TRASLADO', 'CNX MULTIPLE', 'AFECTACION'])],
                    'suministro_aledaño' => ['nullable', 'string', 'max:255'],
                    'referencia' => ['nullable', 'string', 'max:500'],
                    'sed' => ['nullable', 'string', 'max:100'],
                    'alimentador' => ['nullable', 'string', 'max:100'],
                    'departamento_id' => ['nullable', 'exists:ubigeo_departamentos,id'],
                    'provincia_id' => ['nullable', 'exists:ubigeo_provincias,id'],
                    'distrito_id' => ['nullable', 'exists:ubigeo_distritos,id'],
                    'google_maps_link' => ['nullable', 'url', 'starts_with:https://maps.app.goo.gl/,http://maps.app.goo.gl/', 'max:500'],
                    'atributo' => ['nullable', 'string', Rule::in(['Sr.', 'Sra.'])],
                    'nombre_contacto' => ['nullable', 'string', 'max:255'],
                ];
                if ($action === 'iniciar_campo' && $orden->estaPendiente()) {
                    $newState = Orden::ESTADO_EN_CAMPO;
                    $successMessage = 'Fase Anterior guardada. Orden iniciada en campo.';
                } else {
                    $successMessage = 'Datos de Fase Anterior guardados.';
                }
                break;


            case 'guardar_durante':
             case 'finalizar_campo':
                $rules = [
                    'tipo_trabajo' => ['nullable', 'string', Rule::in(['PROYECTO', 'RUTINA'])],
                    'pago_proyecto' => ['nullable', 'string', Rule::in(['pagó', 'aún no paga', 'no aplica'])],
                    'ancho_pasaje' => ['nullable', 'numeric', 'max:999999.99'],
                    'num_poste' => ['nullable', 'numeric', 'max:99999999'],
                    'dist_murete_pto_venta' => ['nullable', 'numeric', 'max:999999.99'],
                    'dist_predio_pto_venta' => ['nullable', 'numeric', 'max:999999.99'],
                    'dist_predio_pasaje' => ['nullable', 'numeric', 'max:999999.99'],
                    'cp' => ['nullable', 'string', 'max:100'],
                    'cantidad_suministros' => ['nullable', 'numeric', 'max:999999'],
                    'suministro_existente' => ['nullable', 'numeric', 'max:999999999'],
                    'suministro_izquierdo' => ['nullable', 'numeric', 'max:999999999'],
                    'suministro_derecho' => ['nullable', 'numeric', 'max:999999999'],
                    'tipo_acometida' => ['nullable', 'string', Rule::in(['Aérea', 'Subterránea'])],
                    'ubicacion_medidor' => ['nullable', 'string', Rule::in(['Fachada', 'Murete'])],
                    'req_caja_paso' => ['nullable', 'boolean'],
                    'req_permiso_mun' => ['nullable', 'boolean'],
                    'req_coord_entidad' => ['nullable', 'boolean'],
                    'incumplimiento_dms' => ['nullable', 'boolean'],
                    'tiene_nicho' => ['nullable', 'boolean'],
                    'uso_servicio' => ['nullable', 'string', 
                    Rule::in(['Doméstico', 'Comercial', 'Alumbrado Público', 'Educación', 'Estructura Metálica', 'Industria Ligera', 'Taller Mecánica'])],
                    'contacto' => ['nullable', 'string', 
                    Rule::in(['cliente', 'hijo del cliente', 'sobrino del cliente', 'esposo del cliente', 'inquilino del cliente', 'contacto del cliente', 'otro'])],
                    'contacto_otro' => ['nullable', 'string', 'max:255', 'required_if:contacto,otro'],
                    'llave' => ['nullable', 'string', 
                    Rule::in(['01', '02', '03'])],
                    'codigo_trafo' => ['nullable', 'string', 'max:50'],                    
                    'observacion' => ['nullable', 'string', 'max:2000'],
                    'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                ];
                if ($orden->estaEnCampo()) {
                    $newState = Orden::ESTADO_POST_CAMPO;
                    $successMessage = 'Fase Durante guardada. Orden finalizada en campo.';
                } else {
                    $successMessage = 'Datos de Fase Durante guardados.';
                }
                break;

            case 'guardar_despues':
            case 'completar_orden':
                $rules = [
                    'fecha_drive_satel' => ['nullable', 'date'],
                    'fecha_scm' => ['nullable', 'date'],
                    'cable_matriz' => ['nullable', 'string', 
                    Rule::in([
                        '2x16+Pmm²', '3x25+Pmm²', '3x35+Pmm²', '3x50+Pmm²', '3x70+Pmm²', '3x95+Pmm²',
                        '3x25+2x16+Pmm²', '3x35+2x16+Pmm²', '3x50+2x16+Pmm²', '3x70+2x16+Pmm²',
                        '3x95+2x16+Pmm²', 'CONCENTRICO TRIPOLAR 6mm²', 'CONCENTRICO TRIPOLAR 4mm²'
                    ])],
                    'predio_dentro_conc_elect' => ['nullable', 'boolean'],
                    'predio_zona_arqueologica' => ['nullable', 'boolean'],
                    'llave_base_fus' => ['nullable', 'string', 'max:100'],
                    'llave_fusible' => ['nullable', 'string', 'max:100'],
                    'llave_cable' => ['nullable', 'string', 
                    Rule::in([
                        'CABLE AL. NA2XY 0.6/1KV. 1-1x 70',
                        'CABLE AL. NA2XY 0.6/1KV. 1-1x150',
                        'CABLE AL. NA2XY 0.6/1KV. 1-1x240',
                        'CABLE AL. NA2XY 0.6/1KV. 1-1x400',
                    ])],
                    'llave_in' => ['nullable', 'string', 'max:100'],
                    'llave_iadm' => ['nullable', 'string', 'max:100'],
                    'llave_ir_valor' => ['nullable', 'numeric'],
                    'llave_ic_valor' => ['nullable', 'numeric'],
                    'llave_ip_valor' => ['nullable', 'numeric'],
                    'trafo_pta' => ['nullable', 'string', 'max:100'],
                    'trafo_vr' => ['nullable', 'string', 'max:100'],
                    'trafo_dmr_valor' => ['nullable', 'numeric'],
                    'trafo_lc_valor' => ['nullable', 'numeric'],
                    'trafo_dmp_valor' => ['nullable', 'numeric'],
                    'descripcion_trabajo' => ['nullable', 'string'],
                    
                    // Reglas para los nuevos campos
                    'descargo_tipo_id_sel' => ['nullable', 'exists:descargo_tipos,id'],
                    'descargo_parte1_id_sel' => ['nullable', 'exists:descargo_parte1s,id'],
                    'descargo_parte2_id_sel' => ['nullable', 'exists:descargo_parte2s,id'],
                    'descargo_parte3_id_sel' => ['nullable', 'exists:descargo_parte3s,id'],
                ];
                if ($action === 'completar_orden' && $orden->estaEnPostCampo()) {
                    $newState = Orden::ESTADO_COMPLETADA;
                    $successMessage = '¡Orden completada exitosamente!';
                } else {
                    $successMessage = 'Datos de Fase Después guardados.';
                }
                break;

            case 'cancelar_orden':
                // ... tu lógica de cancelar_orden ...
                if ($orden->esEditable()) {
                    $newState = Orden::ESTADO_CANCELADA;
                    $successMessage = 'Orden cancelada.';
                } else {
                    return back()->with('error', 'La orden ya está finalizada o en un estado que no permite cancelación.');
                }
                break;
            default:
                Log::warning("Acción no reconocida '{$action}' para Orden #{$orden->id}", ['request_data' => $request->except('password', '_token')]);
                return back()->with('error', 'Acción no reconocida.')->withInput();
        }

        // Validar los datos SOLAMENTE AQUÍ, UNA VEZ.
        if (!empty($rules)) {
            $validatedData = $request->validate($rules);
        }
        // Si no hay reglas, $validatedData seguirá siendo un array vacío.

        try {
    // ======================================================================
    // ========= INICIO: NUEVA LÓGICA PARA MÚLTIPLES FOTOS ==================
    // ======================================================================
    // Se ejecuta solo si la acción es de la fase "Durante" y si se enviaron archivos en el campo 'fotos[]'
    if (($action === 'guardar_durante' || $action === 'finalizar_campo') && $request->hasFile('fotos')) {
        
        // La validación ahora se hace sobre el array de fotos
        $request->validate([
            'fotos'   => ['array', 'max:4'], // Acepta un array con un máximo de 4 archivos
            'fotos.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'] // Cada archivo debe ser una imagen
        ]);

        // Iteramos sobre cada archivo enviado
        foreach ($request->file('fotos') as $file) {
            if ($file->isValid()) {
                // Guardamos el archivo en el disco 'public'
                $path = $file->store('uploads/ordenes_fotos', 'public');
                
                // Creamos un nuevo registro en la tabla 'foto_ordens' asociado a esta orden
                $orden->fotos()->create(['path' => $path]);
            }
        }
        
        Log::info("Se añadieron nuevas fotos a la Orden #{$orden->id}.");
    }
    // ====================================================================
    // ========= FIN: NUEVA LÓGICA PARA MÚLTIPLES FOTOS ===================
    // ====================================================================


    // RECALCULAR VALORES (esta lógica no cambia)
    if ($action === 'guardar_despues' || $action === 'completar_orden') {
        if (isset($validatedData['llave_ir_valor']) && isset($validatedData['llave_ic_valor'])) {
            $validatedData['llave_ip_valor'] = floatval($validatedData['llave_ir_valor'] ?? 0) + floatval($validatedData['llave_ic_valor'] ?? 0);
        } elseif (array_key_exists('llave_ir_valor', $validatedData) || array_key_exists('llave_ic_valor', $validatedData)){
             $validatedData['llave_ip_valor'] = null;
        }

        if (isset($validatedData['trafo_dmr_valor']) && isset($validatedData['trafo_lc_valor'])) {
            $validatedData['trafo_dmp_valor'] = floatval($validatedData['trafo_dmr_valor'] ?? 0) + floatval($validatedData['trafo_lc_valor'] ?? 0);
        } elseif (array_key_exists('trafo_dmr_valor', $validatedData) || array_key_exists('trafo_lc_valor', $validatedData)){
             $validatedData['trafo_dmp_valor'] = null;
        }
    }

    // Actualizar la orden con los campos de texto, etc. (esta lógica no cambia)
    if (!empty($validatedData)) {
        foreach ($validatedData as $key => $value) {
            $orden->{$key} = $value;
        }
        $orden->save();
        Log::info("Datos actualizados para Orden #{$orden->id} via SAVE. Campos: " . json_encode(array_keys($validatedData)));
    } elseif ($action !== 'cancelar_orden' && empty($rules) && !$request->hasFile('fotos')) { // <-- Cambiado a 'fotos'
        Log::info("Acción '{$action}' para Orden #{$orden->id} no actualizó datos validados.");
    }

    // Actualizar estado si es necesario (esta lógica no cambia)
    if ($newState) {
        if ($orden->estado !== $newState) {
            $ordenAnteriorEstado = $orden->estado;
            $orden->estado = $newState;
            $orden->save();
            Log::info("Estado de Orden #{$orden->id} cambiado de '{$ordenAnteriorEstado}' a '{$newState}'.");
        }
    }

    return redirect()->route('ordenes.show', $orden)->with('success', $successMessage);

} catch (\Illuminate\Validation\ValidationException $e) {
    Log::warning("Error de validación al actualizar Orden #{$orden->id} (Acción: {$action}): " . $e->getMessage(), ['errors' => $e->errors()]);
    return back()->withErrors($e->errors())->withInput();

} catch (\Throwable $e) {
    Log::critical("Error fatal al actualizar Orden #{$orden->id} (Acción: {$action}): " . $e->getMessage());
    return back()->withInput()->with('error', 'Ocurrió un error inesperado al actualizar la orden. Inténtalo de nuevo.');
}
    }

    /**
     * Elimina (soft delete) una orden de la base de datos.
     */
   public function destroy(Orden $orden) // Asegúrate que este método exista
    {
        try {
            if ($orden->photo_path && Storage::disk('public')->exists($orden->photo_path)) {
                Storage::disk('public')->delete($orden->photo_path);
                Log::info("Foto '{$orden->photo_path}' eliminada del almacenamiento al dar de baja Orden #{$orden->id}.");
            }
            $orden->delete();
            Log::info("Orden #{$orden->id} eliminada (soft delete).");
            return redirect()->route('ordenes.index')->with('success', 'Orden eliminada (dada de baja) exitosamente.');
        } catch (\Exception $e) {
            Log::error("Error al eliminar orden #{$orden->id}: " . $e->getMessage());
            return redirect()->route('ordenes.index')->with('error', 'Ocurrió un error al intentar eliminar la orden.');
        }
    }
    
}