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
// ============ CÓDIGO OPTIMIZADO PARA PhpWord 1.2.0 =============
// =====================================================================

$fotos = $orden->fotos;

if ($fotos->count() > 0) {
    try {
        // En PhpWord 1.2.0 usar solo cloneBlock sin parámetros adicionales
        $templateProcessor->cloneBlock('bloque_fotos', $fotos->count());

        foreach ($fotos as $index => $foto) {
            $rutaImagen = Storage::disk('public')->path($foto->path);
            
            if (file_exists($rutaImagen)) {
                // Verificar que sea una imagen válida
                $imageInfo = getimagesize($rutaImagen);
                if ($imageInfo !== false && $imageInfo[0] > 0 && $imageInfo[1] > 0) {
                    
                    // Configuración específica para PhpWord 1.2.0
                    $imageOptions = [
                        'path' => $rutaImagen,
                        'width' => 300,    // Tamaño fijo en píxeles
                        'height' => 200,   // Tamaño fijo en píxeles
                        'ratio' => true,   // Mantener proporción
                        'positioning' => 'relative'  // Para 1.2.0
                    ];
                    
                    // Usar setImageValue con el placeholder correcto
                    $templateProcessor->setImageValue('foto#' . ($index + 1), $imageOptions);
                    
                    Log::info("Imagen procesada: {$foto->path} - Tamaño original: {$imageInfo[0]}x{$imageInfo[1]}");
                    
                } else {
                    Log::warning("Archivo no es una imagen válida: $rutaImagen");
                    $templateProcessor->setValue('foto#' . ($index + 1), '[FORMATO DE IMAGEN INVÁLIDO]');
                }
            } else {
                Log::warning("Archivo de imagen no encontrado: $rutaImagen");
                $templateProcessor->setValue('foto#' . ($index + 1), '[IMAGEN NO ENCONTRADA]');
            }
        }
        
        Log::info("Procesadas {$fotos->count()} imágenes para la orden {$orden->id}");
        
    } catch (\Exception $e) {
        Log::error("Error al procesar bloque de imágenes: " . $e->getMessage());
        Log::error("Stack trace: " . $e->getTraceAsString());
        
        // Si hay error, eliminar el bloque y continuar
        try {
            $templateProcessor->deleteBlock('bloque_fotos');
            Log::info("Bloque de fotos eliminado debido a errores");
        } catch (\Exception $deleteError) {
            Log::warning("No se pudo eliminar bloque_fotos: " . $deleteError->getMessage());
        }
    }
} else {
    // No hay fotos, eliminar el bloque
    try {
        $templateProcessor->deleteBlock('bloque_fotos');
        Log::info("Bloque de fotos eliminado - no hay imágenes");
    } catch (\Exception $e) {
        Log::info("Bloque 'bloque_fotos' no existe en la plantilla");
    }
}

// ===================================================================
// ============== GUARDADO Y DESCARGA PARA PhpWord 1.2.0 ============
// ===================================================================

// 8. Generar el nombre del archivo final y guardarlo temporalmente.
$nombreArchivoFinal = 'Reporte-Orden-' . $orden->id . '-' . date('Ymd_His') . '.docx';
$tempPath = storage_path('app/temp_reports');
if (!is_dir($tempPath)) {
    mkdir($tempPath, 0755, true);
}
$rutaGuardado = $tempPath . DIRECTORY_SEPARATOR . $nombreArchivoFinal;

try {
    // Limpiar cualquier output buffer activo
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    // Guardar el documento
    $templateProcessor->saveAs($rutaGuardado);
    
    // Verificaciones post-guardado
    if (!file_exists($rutaGuardado)) {
        throw new \Exception("El archivo no se creó en la ruta esperada: $rutaGuardado");
    }
    
    $fileSize = filesize($rutaGuardado);
    if ($fileSize == 0) {
        throw new \Exception("El archivo generado está vacío");
    }
    
    if ($fileSize < 1000) {
        throw new \Exception("El archivo generado es sospechosamente pequeño ({$fileSize} bytes)");
    }
    
    Log::info("Documento generado exitosamente: {$nombreArchivoFinal} ({$fileSize} bytes)");
    
} catch (\Exception $e) {
    Log::error("Error crítico al generar documento: " . $e->getMessage());
    Log::error("Ruta de guardado: $rutaGuardado");
    
    // Limpiar archivo parcial si existe
    if (file_exists($rutaGuardado)) {
        unlink($rutaGuardado);
    }
    
    return back()->with('error', 'Error al generar el reporte: ' . $e->getMessage());
}

// 9. Guardar registro de reporte generado
try {
    ReporteGenerado::create([
        'orden_id' => $orden->id,
        'user_id' => Auth::id(),
        'plantilla_reporte_id' => $plantilla->id,
        'nombre_archivo_generado' => $nombreArchivoFinal,
    ]);
    Log::info("Reporte registrado en BD: '{$nombreArchivoFinal}' para orden #{$orden->id}");
} catch (\Exception $e) {
    Log::error("Error al registrar en BD (no crítico): " . $e->getMessage());
}

// 10. Descarga optimizada para PhpWord 1.2.0
try {
    // Una última limpieza de buffer
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    // Headers específicos para documentos Word
    $headers = [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'Content-Disposition' => 'attachment; filename="' . $nombreArchivoFinal . '"',
        'Content-Length' => filesize($rutaGuardado),
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => '0'
    ];
    
    return response()->download($rutaGuardado, $nombreArchivoFinal, $headers)
                     ->deleteFileAfterSend(true);
    
} catch (\Exception $e) {
    Log::error("Error en descarga: " . $e->getMessage());
    
    // Limpiar archivo manualmente si la descarga falla
    if (file_exists($rutaGuardado)) {
        unlink($rutaGuardado);
    }
    
    return back()->with('error', 'Error al descargar el reporte generado');
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