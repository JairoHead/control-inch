<?php

namespace App\Http\Controllers;

use App\Models\Inspector;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Para validación unique
use Illuminate\Support\Facades\Log; // Opcional: para logging de errores

class InspectorController extends Controller
{
    /** Muestra lista de inspectores */
    public function index(Request $request) // Añadido Request para la búsqueda (si la implementas aquí)
    {
        

        // --- Lógica Original (Sin búsqueda en controlador, asumida por Livewire) ---
         $inspectores = Inspector::orderBy('apellido_paterno')
                                 ->orderBy('apellido_materno')
                                 ->orderBy('nombres')
                                 ->paginate(15);
         return view('inspectores.index', compact('inspectores')); // Pasar solo $inspectores si usas Livewire para buscar

    }

    /** Muestra formulario de creación */
    public function create()
    {
        return view('inspectores.create');
    }

    /** Guarda nuevo inspector */
    public function store(Request $request)
    {
        // Validación actualizada para DNI opcional y de 8 caracteres
        $validatedData = $request->validate([
            'dni' => [
                'nullable', // <-- Cambiado de 'required'
                'string',
                'max:8',    // <-- Límite máximo
                'min:8',    // <-- Límite mínimo (opcional)
                Rule::unique('inspectores', 'dni')->whereNull('deleted_at') // Único si se ingresa
            ],
            'nombres' => 'required|string|max:50', // Mantenido tu límite max:50
            'apellido_paterno' => 'required|string|max:50', // Mantenido tu límite max:50
            'apellido_materno' => 'required|string|max:50', // Mantenido tu límite max:50
            'nro_celular' => 'nullable|string|max:9', // Mantenido tu límite max:9
        ]);

        try {
            Inspector::create($validatedData);
            return redirect()->route('inspectores.index')
                             ->with('success', 'Inspector creado exitosamente.');
        } catch (\Exception $e) {
             Log::error("Error al crear inspector: " . $e->getMessage()); // Buena idea loguear
             return back()->withInput()->with('error', 'Ocurrió un error al crear el inspector.'); // Mensaje genérico
        }
    }

    /** Muestra detalles de un inspector */
    public function show(Inspector $inspector)
    {
        // Opcional: Cargar relaciones si las muestras en la vista show
        // $inspector->load('ordenes');
        return view('inspectores.show', compact('inspector'));
    }

    /** Muestra formulario de edición */
    public function edit(Inspector $inspector)
    {
        return view('inspectores.edit', compact('inspector'));
    }

    /** Actualiza inspector existente */
    public function update(Request $request, Inspector $inspector)
    {
         // Validación actualizada para DNI opcional y de 8 caracteres
        $validatedData = $request->validate([
            'dni' => [
                'nullable', // <-- Cambiado de 'required'
                'string',
                'max:8',    // <-- Límite máximo
                'min:8',    // <-- Límite mínimo (opcional)
                Rule::unique('inspectores', 'dni')->ignore($inspector->id)->whereNull('deleted_at') // Único, ignorando actual
            ],
            'nombres' => 'required|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'nro_celular' => 'nullable|string|max:9',
        ]);

         try {
            $inspector->update($validatedData);
            return redirect()->route('inspectores.index')
                             ->with('success', 'Inspector actualizado exitosamente.');
         } catch (\Exception $e) {
             Log::error("Error al actualizar inspector {$inspector->id}: " . $e->getMessage());
             return back()->withInput()->with('error', 'Ocurrió un error al actualizar el inspector.');
         }
    }

    /** "Da de baja" (Soft Delete) a un inspector */
    public function destroy(Inspector $inspector)
    {
        try {
            $inspector->delete(); // Soft Delete
            return redirect()->route('inspectores.index')
                             ->with('success', 'Inspector dado de baja exitosamente.');
        } catch (\Exception $e) {
             Log::error("Error al dar de baja inspector {$inspector->id}: " . $e->getMessage());
             return redirect()->route('inspectores.index')
                             ->with('error', 'Ocurrió un error al intentar dar de baja al inspector.');
        }
    }
}