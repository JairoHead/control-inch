@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 flex justify-center">
    <div class="w-full max-w-3xl">

        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="p-6 sm:p-8">

                {{-- Encabezado con Título y Acciones --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700 gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
                            Detalle Cliente
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-1">
                            {{ $cliente->nombre_completo }}
                        </p>
                    </div>
                    <div class="flex space-x-3 flex-shrink-0">
                        <a href="{{ route('clientes.index') }}" class="form-button-secondary text-xs">
                            ← Volver a Lista
                        </a>
                        <a href="{{ route('clientes.edit', $cliente) }}" class="form-button-primary !bg-amber-500 hover:!bg-amber-600 focus:!ring-amber-500 text-xs">
                            Editar Cliente
                        </a>
                    </div>
                </div>

                {{-- Sección de Detalles --}}
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Información Registrada</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5 text-sm">
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">DNI</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $cliente->dni ?? 'No registrado' }}</dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Nombres</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $cliente->nombres }}</dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Apellido Paterno</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $cliente->apellido_paterno }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Apellido Materno</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $cliente->apellido_materno }}</dd>
                        </div>
                         <div class="sm:col-span-2">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Nombre Completo</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $cliente->nombre_completo ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Número Celular</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $cliente->nro_celular ?? 'No registrado' }}</dd>
                        </div>
                    </dl>
                </div>
                 {{-- Sección Órdenes Asociadas (Opcional) --}}
                 {{-- ... (código opcional de órdenes sin cambios) ... --}}
            </div>
        </div>
    </div>
</div>
@endsection