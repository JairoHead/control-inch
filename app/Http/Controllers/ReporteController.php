<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\PlantillaReporte;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\ReporteGenerado;
class ReporteController extends Controller
{
    
    public function index()
    {
        return view('reportes.index');
    }
    public function getPlantillasPorTipo($tipoTrabajo)
    {
        $plantillas = PlantillaReporte::where('tipo_trabajo', $tipoTrabajo)
                                        ->orderBy('nombre_descriptivo')
                                        ->get(['id', 'nombre_descriptivo']);

        return response()->json($plantillas);
    }

    /**
     * Genera y descarga el reporte de una orden específica.
     */
        public function generarReporte(Request $request, Orden $orden)
    {
        // 1. Validar el input.
        $validated = $request->validate([
            'plantilla_id' => 'required|exists:plantilla_reportes,id'
        ]);

        // 2. Encontrar la plantilla.
        $plantilla = PlantillaReporte::findOrFail($validated['plantilla_id']);

        // 3. Construir la ruta al archivo.
        $rutaPlantilla = Storage::disk('public')->path('plantillas_reportes/' . $plantilla->nombre_archivo);
        $rutaNormalizada = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $rutaPlantilla);

        // 4. Comprobar la existencia del archivo.
        if (!file_exists($rutaNormalizada)) {
             Log::error("No se encontró el archivo de plantilla en la ruta: {$rutaNormalizada}");
             return back()->with('error', 'El archivo físico de la plantilla no existe en el servidor.');
        }

        // 5. Cargar la plantilla.
        $templateProcessor = new TemplateProcessor($rutaNormalizada);

        // 6. Reemplazar datos de las RELACIONES (tiene prioridad).
        $templateProcessor->setValue('cliente_nombre', $orden->cliente->nombre_completo ?? 'N/A');
        $templateProcessor->setValue('inspector_nombre', $orden->inspector->nombre_completo ?? 'N/A');
        $templateProcessor->setValue('departamento_nombre', $orden->departamento->departamento ?? 'N/A');
        $templateProcessor->setValue('provincia_nombre', $orden->provincia->provincia ?? 'N/A');
        $templateProcessor->setValue('distrito_nombre', $orden->distrito->distrito ?? 'N/A');

        // Lógica para el contacto.
        $detalleContacto = 'No se especificó contacto.';
        if ($orden->contacto) {
            $tipoContacto = ($orden->contacto === 'otro' && !empty($orden->contacto_otro)) ? $orden->contacto_otro : ucfirst($orden->contacto);
            $detalleContacto = "con {$tipoContacto}, {$orden->nombre_contacto}";
            if ($orden->cliente && $orden->cliente->nro_celular) {
                $detalleContacto .= " con CEL. {$orden->cliente->nro_celular}";
            }
            $detalleContacto .= ".";
        }
        $templateProcessor->setValue('detalle_contacto', $detalleContacto);

        
        $fechaGeneracion = now()->format('d/m/Y');
        $templateProcessor->setValue('fecha_generacion', $fechaGeneracion);
        
        // 7. Reemplazar datos directos de la ORDEN con un bucle mejorado.
        foreach($orden->getAttributes() as $campo => $valor) {
            $valorParaPlantilla = (is_null($valor) || $valor === '') ? 'N/A' : $valor;
            if (is_scalar($valorParaPlantilla)) {
                 $templateProcessor->setValue($campo, $valorParaPlantilla);
            }
        }

// =====================================================================
// ============ TEST: SIN PROCESAMIENTO DE IMÁGENES DINÁMICAS =============
// =====================================================================

$fotos = $orden->fotos;

// COMENTAMOS TODA LA LÓGICA DE IMÁGENES DINÁMICAS
// Solo eliminamos el bloque si existe, sin procesar imágenes
if ($fotos->count() > 0) {
    try {
        // En lugar de procesar imágenes, solo ponemos texto
        $templateProcessor->cloneBlock('bloque_fotos', $fotos->count());
        
        foreach ($fotos as $index => $foto) {
            // Solo texto, sin imágenes
            $templateProcessor->setValue('foto#' . ($index + 1), 'FOTO #' . ($index + 1) . ': ' . $foto->nombre_archivo);
        }
    } catch (\Exception $e) {
        Log::error("Error procesando bloque de fotos: " . $e->getMessage());
        $templateProcessor->deleteBlock('bloque_fotos');
    }
} else {
    try {
        $templateProcessor->deleteBlock('bloque_fotos');
    } catch (\Exception $e) {
        Log::warning("No se pudo eliminar bloque_fotos: " . $e->getMessage());
    }
}

// ===================================================================
// ============== FIN: TEST SIN IMÁGENES ============
// ===================================================================

// 8. Generar el nombre del archivo final y guardarlo temporalmente.
$nombreArchivoFinal = 'TEST-Reporte-Orden-' . $orden->id . '-' . date('Ymd_His') . '.docx';
$tempPath = storage_path('app/temp_reports');
if (!is_dir($tempPath)) {
    mkdir($tempPath, 0755, true);
}
$rutaGuardado = $tempPath . DIRECTORY_SEPARATOR . $nombreArchivoFinal;

try {
    // Limpiar buffer
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    $templateProcessor->saveAs($rutaGuardado);
    
    if (!file_exists($rutaGuardado) || filesize($rutaGuardado) == 0) {
        Log::error("El archivo no se generó correctamente: $rutaGuardado");
        return back()->with('error', 'Error al generar el reporte');
    }
    
    Log::info("TEST - Archivo generado exitosamente. Tamaño: " . filesize($rutaGuardado) . " bytes");
    
} catch (\Exception $e) {
    Log::error("Error al guardar el archivo: " . $e->getMessage());
    return back()->with('error', 'Error al procesar el reporte: ' . $e->getMessage());
}

// 9. Guardar registro de reporte generado
try {
    ReporteGenerado::create([
        'orden_id' => $orden->id,
        'user_id' => Auth::id(),
        'plantilla_reporte_id' => $plantilla->id,
        'nombre_archivo_generado' => $nombreArchivoFinal,
    ]);
    Log::info("TEST - Se registró el reporte '{$nombreArchivoFinal}' para la orden #{$orden->id} por el usuario #" . Auth::id());
} catch (\Exception $e) {
    Log::error("Fallo al registrar el reporte generado para la orden #{$orden->id}: " . $e->getMessage());
}

// 10. Descarga
try {
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    return response()->download($rutaGuardado, $nombreArchivoFinal, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'Content-Disposition' => 'attachment; filename="' . $nombreArchivoFinal . '"',
    ])->deleteFileAfterSend(true);
    
} catch (\Exception $e) {
    Log::error("Error en la descarga: " . $e->getMessage());
    return back()->with('error', 'Error al descargar el reporte');

    
} catch (\Exception $e) {
    Log::error("Error en la descarga: " . $e->getMessage());
    return back()->with('error', 'Error al descargar el reporte');
}
}

    public function destroy(ReporteGenerado $reporte)
    {
        // Opcional: añadir una política de seguridad para ver quién puede borrar
        // if (Auth::user()->cannot('delete', $reporte)) {
        //     abort(403);
        // }
        
        $reporte->delete();

        // Usaremos un mensaje flash de Livewire en lugar de una redirección completa
        // para una mejor experiencia de usuario.
        session()->flash('success', 'Registro de reporte eliminado exitosamente.');
        
        // No redirigimos para que la tabla de Livewire simplemente se refresque.
        return redirect()->route('reportes.index');
    }
}