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
        
        $rutaPlantilla = resource_path('docs/plantillas_reportes/' . $plantilla->nombre_archivo);
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

        $fechaGeneracion = now()->timezone('America/Lima')->format('d/m/Y H:i:s');
        $templateProcessor->setValue('fecha_generacion', $fechaGeneracion);
        
        // 7. Reemplazar datos directos de la ORDEN con un bucle mejorado.

           // Lista de campos booleanos que necesitan transformación
            $camposBooleanos = ['tiene_nicho', 'req_caja_paso', 'req_permiso_mun'];//se pueden agregar más campos booleanos

            $atributos = $orden->getAttributes();

            foreach ($camposBooleanos as $campo) {
                if (array_key_exists($campo, $atributos)) {
                    if ($atributos[$campo] === 1 || $atributos[$campo] === '1') {
                        $atributos[$campo] = 'sí';
                    } elseif ($atributos[$campo] === 0 || $atributos[$campo] === '0') {
                        $atributos[$campo] = 'no';
                    } else {
                        $atributos[$campo] = 'N/A';
                    }
                }
            }

            // $atributos en lugar de volver a llamar getAttributes()
            foreach($atributos as $campo => $valor) {
                $valorParaPlantilla = (is_null($valor) || $valor === '') ? 'N/A' : $valor;
                if (is_scalar($valorParaPlantilla)) {
                    $templateProcessor->setValue($campo, $valorParaPlantilla);
                }
            }
        
        // =====================================================================
        // ============ LÓGICA DE IMÁGENES USANDO TABLAS =============
        // =====================================================================

        $fotos = $orden->fotos;

        if ($fotos->count() > 0) {
            try {
                // CAMBIO CLAVE: usar cloneRow en lugar de cloneBlock
                $templateProcessor->cloneRow('foto', $fotos->count());

                foreach ($fotos as $index => $foto) {
                    $rutaImagen = Storage::disk('public')->path($foto->path);
                    
                    if (file_exists($rutaImagen)) {
                        $imageInfo = getimagesize($rutaImagen);
                        if ($imageInfo !== false && $imageInfo[0] > 0 && $imageInfo[1] > 0) {
                            
                            // Configuración para tabla
                            $imageOptions = [
                                'path' => $rutaImagen,
                                'width' => 400,    
                                'height' => 300,   
                                'ratio' => true
                            ];
                            
                            // Para tablas: foto#1, foto#2, foto#3, etc.
                            $templateProcessor->setImageValue('foto#' . ($index + 1), $imageOptions);
                            
                            Log::info("Imagen #" . ($index + 1) . " procesada en tabla: " . $foto->path);
                            
                        } else {
                            Log::warning("Formato de imagen inválido: $rutaImagen");
                            $templateProcessor->setValue('foto#' . ($index + 1), '[FORMATO DE IMAGEN INVÁLIDO]');
                        }
                    } else {
                        Log::warning("Imagen no encontrada: $rutaImagen");
                        $templateProcessor->setValue('foto#' . ($index + 1), '[IMAGEN NO ENCONTRADA]');
                    }
                }
                
                Log::info("Tabla de fotos procesada: {$fotos->count()} imágenes");
                
            } catch (\Exception $e) {
                Log::error("Error al procesar tabla de imágenes: " . $e->getMessage());
                
                // En caso de error, llenar con mensajes de error
                foreach ($fotos as $index => $foto) {
                    $templateProcessor->setValue('foto#' . ($index + 1), '[ERROR AL CARGAR IMAGEN]');
                }
            }
        } else {
            Log::info("No hay fotos para procesar en la orden {$orden->id}");
            // Si no hay fotos, la fila de la tabla simplemente no se clonará
        }

        // 8. Generar el nombre del archivo final y guardarlo temporalmente.
        $nombreArchivoFinal = 'Reporte-Orden-' . $orden->id . '-' . date('Ymd_His') . '.docx';
        $tempPath = storage_path('app/temp_reports');
        if (!is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }
        $rutaGuardado = $tempPath . DIRECTORY_SEPARATOR . $nombreArchivoFinal;

        try {
            // Limpiar output buffer
            while (ob_get_level()) {
                ob_end_clean();
            }
            
            $templateProcessor->saveAs($rutaGuardado);
            
            if (!file_exists($rutaGuardado) || filesize($rutaGuardado) == 0) {
                throw new \Exception("El archivo no se generó correctamente");
            }
            
            Log::info("Documento generado exitosamente: " . filesize($rutaGuardado) . " bytes");
            
        } catch (\Exception $e) {
            Log::error("Error al generar documento: " . $e->getMessage());
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
            Log::info("Se registró el reporte '{$nombreArchivoFinal}' para la orden #{$orden->id}");
        } catch (\Exception $e) {
            Log::error("Error al registrar en BD: " . $e->getMessage());
        }

        // 10. Descarga
        try {
            while (ob_get_level()) {
                ob_end_clean();
            }
            
            return response()->download($rutaGuardado, $nombreArchivoFinal, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'attachment; filename="' . $nombreArchivoFinal . '"',
            ])->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            Log::error("Error en descarga: " . $e->getMessage());
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