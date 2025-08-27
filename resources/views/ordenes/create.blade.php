@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 flex justify-center">
    <div class="w-full max-w-2xl"> {{-- Ancho máximo para el formulario --}}
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="p-6 sm:p-8">

                <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 text-center">
                        Iniciar Nueva Orden de Trabajo
                    </h1>
                </div>

                @include('partials.flash-messages') {{-- Para errores de validación o sesión --}}

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

                <form action="{{ route('ordenes.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                         {{-- Cliente ID --}}
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="cliente_id">
                                Cliente <span class="text-red-500">*</span>
                            </label>
                             <select name="cliente_id" id="cliente_id" required class="form-select @error('cliente_id') input-error @enderror w-full">
                                <option value="">-- Selecciona un Cliente --</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre_completo }} (DNI: {{ $cliente->dni ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                         {{-- Inspector ID --}}
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="inspector_id">
                                Inspector Asignado <span class="text-red-500">*</span>
                            </label>
                             <select name="inspector_id" id="inspector_id" required class="form-select @error('inspector_id') input-error @enderror w-full">
                                <option value="">-- Selecciona un Inspector --</option>
                                 @foreach ($inspectores as $inspector)
                                    <option value="{{ $inspector->id }}" {{ old('inspector_id') == $inspector->id ? 'selected' : '' }}>
                                        {{ $inspector->nombre_completo ?? ($inspector->apellido_paterno . ' ' . $inspector->nombres) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('inspector_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Descomenta y adapta si necesitas Contrato y Num Insp al crear --}}
                        {{--
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="contrato">Contrato</label>
                            <input type="text" name="contrato" id="contrato" value="{{ old('contrato') }}" class="form-input @error('contrato') input-error @enderror w-full">
                            @error('contrato') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="num_insp"># Inspección</label>
                            <select name="num_insp" id="num_insp" class="form-select @error('num_insp') input-error @enderror w-full">
                                <option value="">-- Seleccione --</option>
                                <option value="1" {{ old('num_insp') == '1' ? 'selected' : '' }}>1 (Primera Vez)</option>
                                <option value="2" {{ old('num_insp') == '2' ? 'selected' : '' }}>2 (Segunda Visita)</option>
                            </select>
                            @error('num_insp') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>
                        --}}

                    </div> {{-- Fin space-y-6 --}}

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 space-x-3">
                        <a href="{{ route('ordenes.index') }}" class="form-button-secondary">
                            Cancelar
                        </a>
                        <button class="form-button-primary" type="submit">
                            Iniciar Orden y Completar Datos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection