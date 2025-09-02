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
                            Detalle de Usuario
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-1">
                            {{ $user->name }}
                        </p>
                    </div>
                    <div class="flex space-x-3 flex-shrink-0">
                        <a href="{{ route('admin.users.index') }}" class="form-button-secondary text-xs">
                            ← Volver a Lista
                        </a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="form-button-primary !bg-amber-500 hover:!bg-amber-600 focus:!ring-amber-500 text-xs">
                            Editar Usuario
                        </a>
                    </div>
                </div>
                <div class="flex flex-col items-center sm:flex-row sm:items-center mb-6">
                    <img class="h-24 w-24 rounded-full object-cover bg-gray-200" 
                         src="{{ $user->profile_photo_url }}" 
                         alt="Foto de perfil de {{ $user->name }}">
                    
                    <div class="mt-4 sm:mt-0 sm:ml-6 text-center sm:text-left">
                        {{-- Ya no repetimos el nombre y email aquí, ya están arriba o abajo --}}
                        <p class="text-md text-gray-600 dark:text-gray-400">
                            {{-- Mantenemos el email aquí para que esté junto a la foto --}}
                            {{ $user->email }}
                        </p>
                    </div>
                </div>

                {{-- Sección de Detalles del Usuario --}}
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Información de la Cuenta</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5 text-sm">
                        
                        <div class="sm:col-span-2">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Nombre Completo</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $user->name }}</dd>
                        </div>
                        
                        <div class="sm:col-span-2">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Correo Electrónico</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $user->email }}</dd>
                        </div>
                        
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Rol</dt>
                            <dd class="mt-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                            <dd class="mt-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Fecha de Registro</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $user->created_at->format('d/m/Y H:i A') }}</dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Última Actualización</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $user->updated_at->diffForHumans() }}</dd>
                        </div>

                    </dl>
                </div>
                 
                {{-- (Opcional) Si quieres mostrar las órdenes asociadas, necesitarás una relación --}}
                {{-- @if($user->ordenesAsignadas && $user->ordenesAsignadas->count() > 0)
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Órdenes Recientes Asignadas</h2>
                    ... (lógica de bucle para mostrar órdenes) ...
                </div>
                @endif --}}

            </div>
        </div>
    </div>
</div>
@endsection