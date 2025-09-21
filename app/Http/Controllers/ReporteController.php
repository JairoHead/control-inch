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
// ============ INICIO: LÓGICA DE IMÁGENES (SOLUCIÓN PhpWord 1.3.0) =============
// =====================================================================

$fotos = $orden->fotos;

if ($fotos->count() > 0) {
    try {
        // CAMBIO CRÍTICO: Usar cloneRow en lugar de cloneBlock para PhpWord 1.3.0
        // Si tu plantilla usa una tabla para las fotos, usa cloneRow
        // Si usa bloques, mantén cloneBlock pero con parámetros específicos
        
        // OPCIÓN 1: Si usas tabla en tu plantilla Word (recomendado)
        $templateProcessor->cloneRow('foto', $fotos->count());
        
        // OPCIÓN 2: Si usas bloques (comentar la línea de arriba y descomentar esta)
        // $templateProcessor->cloneBlock('bloque_fotos', $fotos->count(), true, false);

        foreach ($fotos as $index => $foto) {
            $rutaImagen = Storage::disk('public')->path($foto->path);
            
            if (file_exists($rutaImagen)) {
                // Verificar que sea una imagen válida
                $imageInfo = getimagesize($rutaImagen);
                if ($imageInfo !== false) {
                    // --- CONFIGURACIÓN SIMPLIFICADA PARA PhpWord 1.3.0 ---
                    $imageOptions = [
                        'path' => $rutaImagen,
                        'width' => 400,  // Valor fijo en píxeles (sin 'px')
                        'height' => 300, // Valor fijo en píxeles (sin 'px')
                        'ratio' => false // CAMBIO IMPORTANTE: false para evitar bugs
                    ];
                    
                    // CAMBIO: Usar índice base 1 o base 0 según tu plantilla
                    $templateProcessor->setImageValue('foto#' . ($index + 1), $imageOptions);
                } else {
                    Log::warning("Formato de imagen inválido: $rutaImagen");
                    $templateProcessor->setValue('foto#' . ($index + 1), '[FORMATO DE IMAGEN INVÁLIDO]');
                }
            } else {
                Log::warning("Imagen no encontrada: $rutaImagen");
                $templateProcessor->setValue('foto#' . ($index + 1), '[IMAGEN NO ENCONTRADA]');
            }
        }
    } catch (\Exception $e) {
        Log::error("Error procesando imágenes en reporte: " . $e->getMessage());
        // Eliminar el bloque/fila si hay problemas
        try {
            $templateProcessor->deleteBlock('bloque_fotos');
        } catch (\Exception $deleteError) {
            Log::warning("No se pudo eliminar bloque_fotos: " . $deleteError->getMessage());
        }
    }
} else {
    try {
        $templateProcessor->deleteBlock('bloque_fotos');
    } catch (\Exception $e) {
        Log::warning("No se pudo eliminar bloque_fotos vacío: " . $e->getMessage());
    }
}

// ===================================================================
// ============== FIN: LÓGICA DE IMÁGENES ============
// ===================================================================

// 8. Generar el nombre del archivo final y guardarlo temporalmente.
$nombreArchivoFinal = 'Reporte-Orden-' . $orden->id . '-' . date('Ymd_His') . '.docx';
$tempPath = storage_path('app/temp_reports');
if (!is_dir($tempPath)) {
    mkdir($tempPath, 0755, true);
}
$rutaGuardado = $tempPath . DIRECTORY_SEPARATOR . $nombreArchivoFinal;

try {
    // CAMBIO IMPORTANTE: Limpiar el buffer antes de guardar
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    $templateProcessor->saveAs($rutaGuardado);
    
    // Verificar que el archivo se generó correctamente
    if (!file_exists($rutaGuardado) || filesize($rutaGuardado) == 0) {
        Log::error("El archivo no se generó correctamente: $rutaGuardado");
        return back()->with('error', 'Error al generar el reporte');
    }
    
    Log::info("Archivo generado exitosamente. Tamaño: " . filesize($rutaGuardado) . " bytes");
    
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
    Log::info("Se registró el reporte '{$nombreArchivoFinal}' para la orden #{$orden->id} por el usuario #" . Auth::id());
} catch (\Exception $e) {
    Log::error("Fallo al registrar el reporte generado para la orden #{$orden->id}: " . $e->getMessage());
}

// 10. DESCARGA MEJORADA para PhpWord 1.3.0
try {
    // Limpiar cualquier output buffer
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    return response()->download($rutaGuardado, $nombreArchivoFinal, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'Content-Disposition' => 'attachment; filename="' . $nombreArchivoFinal . '"',
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => '0'
    ])->deleteFileAfterSend(true);
    
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