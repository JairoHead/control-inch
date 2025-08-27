<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log; // Para logging

class ClienteController extends Controller
{
    /** Muestra lista de clientes */
    public function index(Request $request) // Preparado para Livewire o búsqueda tradicional
    {
       
        return view('clientes.index'); // Asume que aquí se carga @livewire('clientes-table')
    }

    /** Muestra formulario de creación */
    public function create()
    {
        return view('clientes.create');
    }

    /** Guarda nuevo cliente */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'dni' => [
                'nullable', // Opcional
                'string',
                'max:8',    // Máximo 8 caracteres
                'min:8',    // Opcional: Mínimo 8 caracteres si se ingresa
                Rule::unique('clientes', 'dni')->whereNull('deleted_at') // Único entre clientes no borrados
            ],
            'nombres' => 'required|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'nro_celular' => 'nullable|string|max:9', // Máximo 9 dígitos
        ]);

        try {
            Cliente::create($validatedData);
            return redirect()->route('clientes.index')
                             ->with('success', 'Cliente creado exitosamente.');
        } catch (\Exception $e) {
             Log::error("Error al crear cliente: " . $e->getMessage());
             return back()->withInput()->with('error', 'Ocurrió un error al crear el cliente.');
        }
    }

    /** Muestra detalles de un cliente */
    public function show(Cliente $cliente)
    {
        // Opcional: Cargar órdenes asociadas si las muestras en la vista show
        // $cliente->load('ordenes');
        return view('clientes.show', compact('cliente'));
    }

    /** Muestra formulario de edición */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /** Actualiza cliente existente */
    public function update(Request $request, Cliente $cliente)
    {
        $validatedData = $request->validate([
            'dni' => [
                'nullable',
                'string',
                'max:8',
                'min:8', // Opcional
                Rule::unique('clientes', 'dni')->ignore($cliente->id)->whereNull('deleted_at') // Único, ignorando el actual
            ],
            'nombres' => 'required|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'nro_celular' => 'nullable|string|max:9',
        ]);

        try {
            $cliente->update($validatedData);
            return redirect()->route('clientes.index')
                             ->with('success', 'Cliente actualizado exitosamente.');
        } catch (\Exception $e) {
             Log::error("Error al actualizar cliente {$cliente->id}: " . $e->getMessage());
             return back()->withInput()->with('error', 'Ocurrió un error al actualizar el cliente.');
        }
    }

    /** "Da de baja" (Soft Delete) a un cliente */
    public function destroy(Cliente $cliente)
    {
        // Lógica opcional para prevenir si tiene órdenes activas
        // if ($cliente->ordenes()->whereNotIn('estado', [Orden::ESTADO_COMPLETADA, Orden::ESTADO_CANCELADA])->exists()) {
        //     return redirect()->route('clientes.index')
        //                      ->with('error', 'No se puede dar de baja al cliente porque tiene órdenes activas.');
        // }

        try {
            $cliente->delete(); // Soft Delete
            return redirect()->route('clientes.index')
                             ->with('success', 'Cliente dado de baja exitosamente.');
        } catch (\Exception $e) {
             Log::error("Error al dar de baja cliente {$cliente->id}: " . $e->getMessage());
             return redirect()->route('clientes.index')
                             ->with('error', 'Ocurrió un error al intentar dar de baja al cliente.');
        }
    }
}