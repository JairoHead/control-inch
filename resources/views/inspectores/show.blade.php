@extends('layouts.app')

@section('content')
{{-- Contenedor con padding y centrado --}}
<div class="py-8 px-4 sm:px-6 lg:px-8 flex justify-center">
    <div class="w-full max-w-3xl"> {{-- Ancho máximo un poco mayor para 'show' --}}

        {{-- Panel/Tarjeta Blanca --}}
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="p-6 sm:p-8">

                {{-- Encabezado con Título y Acciones --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700 gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
                            Detalle Inspector
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-1">
                            {{ $inspector->nombre_completo ?? ($inspector->nombres . ' ' . $inspector->apellido_paterno) }}
                        </p>
                    </div>
                    <div class="flex space-x-3 flex-shrink-0">
                        <a href="{{ route('inspectores.index') }}" class="form-button-secondary text-xs">
                            ← Volver a Lista
                        </a>
                        <a href="{{ route('inspectores.edit', $inspector) }}" class="form-button-primary !bg-amber-500 hover:!bg-amber-600 focus:!ring-amber-500 text-xs"> {{-- Botón editar amarillo --}}
                            Editar Inspector
                        </a>
                        {{-- Botón Dar de Baja (Opcional) --}}
                        {{--
                        <form action="{{ route('inspectores.destroy', $inspector) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="form-button-danger text-xs">
                                Dar de Baja
                            </button>
                        </form>
                        --}}
                    </div>
                </div>

                {{-- Sección de Detalles --}}
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Información Registrada</h2>
                    {{-- Lista de Definición (dl) para mostrar datos --}}
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5 text-sm">
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">DNI</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $inspector->dni ?? 'No registrado' }}</dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Nombres</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $inspector->nombres }}</dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Apellido Paterno</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $inspector->apellido_paterno }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Apellido Materno</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $inspector->apellido_materno }}</dd>
                        </div>
                         <div class="sm:col-span-2"> {{-- Ocupa todo el ancho --}}
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Nombre Completo</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $inspector->nombre_completo ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Número Celular</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $inspector->nro_celular ?? 'No registrado' }}</dd>
                        </div>

                        {{-- Añade aquí otros campos del inspector si los tienes, usando la misma estructura dt/dd --}}
                        {{-- Ejemplo:
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Código Interno</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $inspector->codigo_interno ?? 'N/A' }}</dd>
                        </div>
                        --}}

                    </dl>
                </div>

                {{-- Sección Órdenes Asociadas (Opcional) - Misma lógica que para Clientes --}}
                {{-- Necesitarías cargar la relación 'ordenes' en InspectorController@show --}}
                {{--
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Órdenes Asignadas</h2>
                    @if($inspector->ordenes && $inspector->ordenes->count() > 0)
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            @foreach($inspector->ordenes as $orden)
                                <li>
                                    <a href="{{ route('ordenes.show', $orden) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                        Orden #{{ $orden->id }} ({{ $orden->num_insp }}) - Estado: {{ $orden->estado_legible }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                       <p class="text-sm text-gray-500 dark:text-gray-400">Este inspector no tiene órdenes asignadas.</p>
                    @endif
                </div>
                --}}

            </div> {{-- Fin Panel Interno (Padding) --}}
        </div> {{-- Fin Panel/Tarjeta Blanca --}}
    </div> {{-- Fin Contenedor Centrado --}}
</div> {{-- Fin Contenedor Principal de la Vista --}}
@endsection