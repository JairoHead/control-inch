@extends('layouts.app')

@section('content')
{{-- Contenedor con padding y centrado para el formulario --}}
<div class="py-8 px-4 sm:px-6 lg:px-8 flex justify-center">
    <div class="w-full max-w-2xl"> {{-- Limita el ancho del formulario para mejor legibilidad --}}

        {{-- Panel/Tarjeta Blanca --}}
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            {{-- Padding interno para el contenido del panel --}}
            <div class="p-6 sm:p-8">

                {{-- Encabezado del Formulario --}}
                <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 text-center">
                        Crear Nuevo Cliente
                    </h1>
                </div>

                {{-- Mensajes Flash de Errores de Validación --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-900 dark:border-red-700 dark:text-red-300 rounded-md" role="alert">
                        <div class="flex">
                            <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 dark:text-red-300 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                            <div>
                                <p class="font-bold">¡Error de validación!</p>
                                <ul class="mt-1 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        {{-- DNI (Opcional, 8 caracteres) --}}
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="dni">
                                DNI <span class="text-xs font-light text-gray-500 dark:text-gray-400">(Opcional, 8 caracteres)</span>
                            </label>
                            <input class="form-input @error('dni') input-error @enderror w-full"
                                   id="dni" type="text" name="dni" value="{{ old('dni') }}"
                                   maxlength="8" pattern="\d{8}" title="El DNI debe contener 8 dígitos (opcional).">
                            @error('dni') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Nombres (Requerido) --}}
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="nombres">
                                Nombres <span class="text-red-500">*</span>
                            </label>
                            <input class="form-input @error('nombres') input-error @enderror w-full"
                                   id="nombres" type="text" name="nombres" value="{{ old('nombres') }}" required>
                            @error('nombres') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                         {{-- Apellido Paterno (Requerido) --}}
                         <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="apellido_paterno">
                                Apellido Paterno <span class="text-red-500">*</span>
                            </label>
                            <input class="form-input @error('apellido_paterno') input-error @enderror w-full"
                                   id="apellido_paterno" type="text" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required>
                            @error('apellido_paterno') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Apellido Materno (Requerido) --}}
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="apellido_materno">
                                Apellido Materno <span class="text-red-500">*</span>
                            </label>
                            <input class="form-input @error('apellido_materno') input-error @enderror w-full"
                                   id="apellido_materno" type="text" name="apellido_materno" value="{{ old('apellido_materno') }}" required>
                            @error('apellido_materno') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Número Celular (Opcional, 9 caracteres) --}}
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="nro_celular">
                                Número Celular <span class="text-xs font-light text-gray-500 dark:text-gray-400">(Opcional, 9 dígitos)</span>
                            </label>
                            <input class="form-input @error('nro_celular') input-error @enderror w-full"
                                   id="nro_celular" type="text" name="nro_celular" value="{{ old('nro_celular') }}"
                                   placeholder="Ej: 987654321" maxlength="9" pattern="\d{9}">
                            @error('nro_celular') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div> {{-- Fin grid --}}

                    {{-- Botones --}}
                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 space-x-3">
                        <a href="{{ route('clientes.index') }}" class="form-button-secondary">
                            Cancelar
                        </a>
                        <button class="form-button-primary" type="submit">
                            Guardar Cliente
                        </button>
                    </div>

                </form>
            </div> {{-- Fin Panel Interno --}}
        </div> {{-- Fin Panel/Tarjeta Blanca --}}
    </div> {{-- Fin Contenedor Centrado --}}
</div> {{-- Fin Contenedor Principal de la Vista --}}
@endsection