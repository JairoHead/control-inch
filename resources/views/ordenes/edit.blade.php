@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold text-gray-700 mb-1">Editar Orden: {{ $orden->numero_orden }}</h1>
    <p class="text-lg text-gray-600 mb-4">Estado Actual:
         <span class="font-semibold px-2 py-0.5 rounded
            @if($orden->estaPendiente()) bg-yellow-100 text-yellow-800 @endif
            @if($orden->estaEnCampo()) bg-blue-100 text-blue-800 @endif
            @if($orden->estaEnPostCampo()) bg-indigo-100 text-indigo-800 @endif
        ">
            {{ ucfirst(str_replace('_', ' ', $orden->estado)) }}
        </span>
    </p>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
             <strong class="font-bold">¡Error de validación!</strong>
            <ul> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
        </div>
    @endif

    <form action="{{ route('ordenes.update', $orden) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        {{-- SECCIÓN DATOS GENERALES (Algunos podrían ser no editables aquí) --}}
        <fieldset class="mb-6 border p-4 rounded">
            <legend class="font-semibold px-2">Datos Generales</legend>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                 <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="numero_orden">Número de Orden</label>
                    <input type="text" name="numero_orden" id="numero_orden" value="{{ old('numero_orden', $orden->numero_orden) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('numero_orden') border-red-500 @enderror">
                    @error('numero_orden') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                </div>
                 <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="fecha_inspeccion">Fecha Inspección</label>
                    <input type="date" name="fecha_inspeccion" id="fecha_inspeccion" value="{{ old('fecha_inspeccion', $orden->fecha_inspeccion ? \Carbon\Carbon::parse($orden->fecha_inspeccion)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('fecha_inspeccion') border-red-500 @enderror">
                     @error('fecha_inspeccion') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                </div>
                {{-- Mostrar Cliente e Inspector (normalmente no se cambian) --}}
                <div class="mt-2">
                    <span class="text-gray-700 text-sm font-bold">Cliente:</span> {{ $orden->cliente->nombre_completo ?? 'N/A' }}
                </div>
                 <div class="mt-2">
                    <span class="text-gray-700 text-sm font-bold">Inspector:</span> {{ $orden->inspector->nombre ?? 'N/A' }}
                </div>
                 <div class="md:col-span-2">
                     <label class="block text-gray-700 text-sm font-bold mb-2" for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $orden->descripcion) }}</textarea>
                    @error('descripcion') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                 </div>
            </div>
        </fieldset>


        {{-- SECCIÓN DATOS DE CAMPO --}}
        {{-- Mostrar siempre la sección, pero deshabilitar inputs si no es la etapa activa --}}
        <fieldset class="mb-6 border p-4 rounded @if(!$orden->estaEnCampo() && !$orden->estaPendiente()) bg-gray-50 opacity-70 @endif">
            <legend class="font-semibold px-2">Etapa: Datos de Campo</legend>

            {{-- Inputs para datos de campo --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                 <div>
                     <label class="block text-gray-700 text-sm font-bold mb-2" for="lectura_campo_1">Lectura Campo 1</label>
                     <input type="text" name="lectura_campo_1" id="lectura_campo_1"
                            value="{{ old('lectura_campo_1', $orden->lectura_campo_1 ?? '') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('lectura_campo_1') border-red-500 @enderror"
                            {{ ($orden->estaEnCampo() || $orden->estaPendiente()) ? '' : 'disabled' }}> {{-- Deshabilitar si no está en la etapa correcta --}}
                     @error('lectura_campo_1') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                 </div>
                 {{-- Añade aquí más campos específicos de la etapa "En Campo" --}}
                 <div>
                    {{-- Otro campo ejemplo --}}
                 </div>
            </div>

             {{-- Botones de acción para esta etapa --}}
             <div class="mt-4 flex justify-end space-x-2">
                @if($orden->estaPendiente())
                    <button type="submit" name="action" value="iniciar_campo" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                        Iniciar Trabajo en Campo
                    </button>
                @elseif($orden->estaEnCampo())
                    <button type="submit" name="action" value="guardar_campo" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                        Guardar Datos Campo
                    </button>
                     <button type="submit" name="action" value="pasar_a_postcampo" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                        Finalizar Campo y Pasar a Post-Campo
                    </button>
                @endif
            </div>
        </fieldset>


        {{-- SECCIÓN DATOS POST-CAMPO --}}
        <fieldset class="mb-6 border p-4 rounded @if(!$orden->estaEnPostCampo()) bg-gray-50 opacity-70 @endif">
             <legend class="font-semibold px-2">Etapa: Datos Post-Campo</legend>

             {{-- Inputs para datos post-campo --}}
             <div class="grid grid-cols-1 gap-4">
                  <div>
                     <label class="block text-gray-700 text-sm font-bold mb-2" for="observaciones_finales">Observaciones Finales</label>
                     <textarea name="observaciones_finales" id="observaciones_finales" rows="4"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('observaciones_finales') border-red-500 @enderror"
                               {{ $orden->estaEnPostCampo() ? '' : 'disabled' }}>{{ old('observaciones_finales', $orden->observaciones_finales ?? '') }}</textarea>
                    @error('observaciones_finales') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                 </div>
                  {{-- Añade aquí más campos específicos de la etapa "Post-Campo" --}}
             </div>

             {{-- Botones de acción para esta etapa --}}
             <div class="mt-4 flex justify-end space-x-2">
                 @if($orden->estaEnPostCampo())
                      <button type="submit" name="action" value="guardar_postcampo" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                         Guardar Datos Post-Campo
                     </button>
                      <button type="submit" name="action" value="completar_orden" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                         Marcar Orden como Completada
                     </button>
                 @endif
             </div>
        </fieldset>

         {{-- Botones Generales (Cancelar / Cancelar Orden) --}}
        <div class="flex items-center justify-between mt-6">
            <div>
                <a href="{{ route('ordenes.show', $orden) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    Cancelar Edición
                </a>
            </div>
             {{-- Botón para Cancelar la orden (si aplica) --}}
             @if($orden->estaPendiente() || $orden->estaEnCampo() || $orden->estaEnPostCampo())
             <div>
                 <button type="submit" name="action" value="cancelar_orden" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300" onclick="return confirm('¿Estás seguro de que quieres CANCELAR esta orden? Esta acción no se puede deshacer fácilmente.')">
                     Cancelar Orden
                 </button>
             </div>
             @endif
        </div>

    </form>
</div>
@endsection