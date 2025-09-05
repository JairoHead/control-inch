@extends('layouts.app') {{-- Usamos la misma sintaxis que tus otras vistas --}}

@section('content') {{-- Ponemos todo el contenido dentro de la sección 'content' --}}

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- =============================================== --}}
        {{-- ============ INICIO: PANEL DEL PERFIL =========== --}}
        {{-- =============================================== --}}
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="p-6 sm:p-8">
                
                {{-- Título --}}
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Mi Perfil
                    </h2>
                    {{-- Botón para volver al dashboard/lista de órdenes --}}
                    <a href="{{ route('ordenes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Volver al Dashboard
                    </a>
                </div>

                {{-- Avatar y Nombre --}}
                <div class="flex flex-col items-center sm:flex-row sm:items-center">
                    <img class="h-24 w-24 rounded-full object-cover" 
                         src="{{ Auth::user()->profile_photo_url }}" 
                         alt="{{ Auth::user()->name }}">
                    
                    <div class="mt-4 sm:mt-0 sm:ml-6 text-center sm:text-left">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ Auth::user()->name }}
                        </h1>
                        <p class="text-md text-gray-600 dark:text-gray-400">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                </div>
                <hr class="my-6 border-gray-200 dark:border-gray-700">

                {{-- Sección de Detalles Adicionales --}}
                <div>
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">
                        Detalles de la Cuenta
                    </h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5 text-sm">
                        
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Rol</dt>
                            <dd class="mt-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ Auth::user()->role === 'admin' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                            <dd class="mt-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ Auth::user()->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ Auth::user()->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Fecha de Registro</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ Auth::user()->created_at->format('d/m/Y') }}</dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Última Actualización</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ Auth::user()->updated_at->diffForHumans() }}</dd>
                        </div>

                    </dl>
                </div>

            </div>
        </div>
        {{-- =============================================== --}}
        {{-- ============= FIN: PANEL DEL PERFIL ============= --}}
        {{-- =============================================== --}}

    </div>
</div>

@endsection