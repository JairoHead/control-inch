@extends('layouts.app')

@section('content')
<div class="flex justify-center"> {{-- 1. Contenedor para centrar --}}
    <div class="w-full max-w-8xl"> {{-- 2. Contenedor para ancho máximo (ajusta max-w-XXX según necesites) --}}
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden"> {{-- 3. El panel/tarjeta --}}
            <div class="p-6 sm:p-8"> {{-- 4. Padding interno del panel --}}

                {{-- Encabezado del formulario --}}
                <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 text-center">
                        Editar Orden #{{ $orden->id }} - Fase: Trabajo en Campo (Durante)
                    </h1>
                    <p class="text-center text-gray-600 dark:text-gray-400 mt-1">Estado Actual: <span class="font-semibold">{{ $orden->estado_legible }}</span></p>
                </div>
    @include('partials.flash-messages')

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">¡Error de validación!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="orden-form-durante" action="{{ route('ordenes.update', $orden) }}" method="POST" enctype="multipart/form-data">        
        @csrf
        @method('PATCH')

        {{-- Layout de una columna para móviles --}}
        <div class="space-y-6">

            {{-- Tipo Trabajo (Selección) y Pago Proyecto (Selección) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="tipo_trabajo">Tipo Trabajo</label>
                    <select name="tipo_trabajo" id="tipo_trabajo" class="form-select">
                        <option value="">-- Seleccione --</option>
                        <option value="PROYECTO" {{ old('tipo_trabajo', $orden->tipo_trabajo) == 'PROYECTO' ? 'selected' : '' }}>Proyecto</option>
                        <option value="RUTINA" {{ old('tipo_trabajo', $orden->tipo_trabajo) == 'RUTINA' ? 'selected' : '' }}>Rutina</option>
                         {{-- Añade más si es necesario --}}
                    </select>
                    @error('tipo_trabajo') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="pago_proyecto">Pago Proyecto</label>
                     <select name="pago_proyecto" id="pago_proyecto" class="form-select">
                        <option value="">-- Seleccione --</option>
                        <option value="pagó" {{ old('pago_proyecto', $orden->pago_proyecto) == 'pagó' ? 'selected' : '' }}>Pagó</option>
                        <option value="aún no paga" {{ old('pago_proyecto', $orden->pago_proyecto) == 'aún no paga' ? 'selected' : '' }}>Aún no paga</option>
                        <option value="no aplica" {{ old('pago_proyecto', $orden->pago_proyecto) == 'no aplica' ? 'selected' : '' }}>No Aplica</option>
                         {{-- Añade más si es necesario --}}
                    </select>
                    @error('pago_proyecto') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

             {{-- Ancho Pasaje (Texto Libre) y Número Poste (Texto Libre) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="ancho_pasaje">Ancho Pasaje</label>
                    <input class="form-input" id="ancho_pasaje" type="text" name="ancho_pasaje" value="{{ old('ancho_pasaje', $orden->ancho_pasaje) }}">
                    @error('ancho_pasaje') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="num_poste">Número Poste</label>
                    <input class="form-input" id="num_poste" type="text" name="num_poste" value="{{ old('num_poste', $orden->num_poste) }}">
                    @error('num_poste') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Distancias (Texto Libre) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                 <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="dist_murete_pto_venta">Dist. Murete a Pto. Venta</label>
                    <input class="form-input" id="dist_murete_pto_venta" type="text" name="dist_murete_pto_venta" value="{{ old('dist_murete_pto_venta', $orden->dist_murete_pto_venta) }}">
                    @error('dist_murete_pto_venta') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                </div>
                 <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="dist_predio_pto_venta">Dist. Predio a Pto. Venta</label>
                    <input class="form-input" id="dist_predio_pto_venta" type="text" name="dist_predio_pto_venta" value="{{ old('dist_predio_pto_venta', $orden->dist_predio_pto_venta) }}">
                    @error('dist_predio_pto_venta') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                </div>
                {{-- NUEVO CAMPO --}}
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="dist_predio_pasaje">Dist. Predio a Pasaje</label>
                    <input class="form-input" id="dist_predio_pasaje" type="text" name="dist_predio_pasaje" value="{{ old('dist_predio_pasaje', $orden->dist_predio_pasaje) }}">
                    @error('dist_predio_pasaje') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="cp">Centro Poblado</label>
                    <input class="form-input" id="cp" type="text" name="cp" value="{{ old('cp', $orden->cp) }}">
                    @error('cp') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="cantidad_suministros">Cantidad de Suministros</label>
                    <input class="form-input" id="cantidad_suministros" type="text" name="cantidad_suministros" value="{{ old('cantidad_suministros', $orden->cantidad_suministros) }}">
                    @error('cantidad_suministros') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="suministro_existente">Suministro Existente</label>
                    <input class="form-input" id="suministro_existente" type="text" name="suministro_existente" value="{{ old('suministro_existente', $orden->suministro_existente) }}">
                    @error('suministro_existente') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="tipo_acometida">Tipo Acometida</label>
                    <select name="tipo_acometida" id="tipo_acometida" class="form-select">
                        <option value="">-- Seleccione --</option>
                        <option value="Aérea" {{ old('tipo_acometida', $orden->tipo_acometida) == 'Aérea' ? 'selected' : '' }}>Aérea</option>
                        <option value="Subterránea" {{ old('tipo_acometida', $orden->tipo_acometida) == 'Subterránea' ? 'selected' : '' }}>Subterránea</option>
                         {{-- Añade más si es necesario --}}
                    </select>
                    @error('tipo_acometida') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="ubicacion_medidor">Ubicación Medidor</label>
                 <select name="ubicacion_medidor" id="ubicacion_medidor" class="form-select">
                    <option value="">-- Seleccione --</option>
                    <option value="Fachada" {{ old('ubicacion_medidor', $orden->ubicacion_medidor) == 'Fachada' ? 'selected' : '' }}>Fachada</option>
                    <option value="Murete" {{ old('ubicacion_medidor', $orden->ubicacion_medidor) == 'Murete' ? 'selected' : '' }}>Murete</option>
                     {{-- Añade más si es necesario --}}
                </select>
                @error('ubicacion_medidor') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>
            </div>


            <hr class="my-6 border-gray-300 dark:border-gray-600">

            {{-- Requerimientos (Checkboxes Sí/No) --}}
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Requerimientos y Condiciones</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                {{-- Req. Caja Paso --}}
                <div class="flex items-center">
                    <input type="hidden" name="req_caja_paso" value="0">
                    <input id="req_caja_paso" name="req_caja_paso" type="checkbox" value="1" {{ old('req_caja_paso', $orden->req_caja_paso) ? 'checked' : '' }} class="form-checkbox">
                    <label for="req_caja_paso" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                        ¿Req. Caja Paso?
                    </label>
                </div>
                 {{-- Req. Permiso Municipal --}}
                <div class="flex items-center">
                     <input type="hidden" name="req_permiso_mun" value="0">
                     <input id="req_permiso_mun" name="req_permiso_mun" type="checkbox" value="1" {{ old('req_permiso_mun', $orden->req_permiso_mun) ? 'checked' : '' }} class="form-checkbox">
                    <label for="req_permiso_mun" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                        ¿Req. Permiso Mun.?
                    </label>
                </div>
                 {{-- Req. Coord. Entidad --}}
                <div class="flex items-center">
                    <input type="hidden" name="req_coord_entidad" value="0">
                    <input id="req_coord_entidad" name="req_coord_entidad" type="checkbox" value="1" {{ old('req_coord_entidad', $orden->req_coord_entidad) ? 'checked' : '' }} class="form-checkbox">
                     <label for="req_coord_entidad" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                        ¿Se Req. Coord. Entidad?
                    </label>
                </div>
                 {{-- Existen Incumplimientos DMS --}}
                <div class="flex items-center">
                    <input type="hidden" name="incumplimiento_dms" value="0"> {{-- Asumimos que este también es Sí/No ahora --}}
                    <input id="incumplimiento_dms" name="incumplimiento_dms" type="checkbox" value="1" {{ old('incumplimiento_dms', $orden->incumplimiento_dms) ? 'checked' : '' }} class="form-checkbox">
                     <label for="incumplimiento_dms" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                        ¿Existen Incump. DMS?
                    </label>
                </div>
                 {{-- Tiene Nicho --}}
                <div class="flex items-center">
                    <input type="hidden" name="tiene_nicho" value="0">
                    <input id="tiene_nicho" name="tiene_nicho" type="checkbox" value="1" {{ old('tiene_nicho', $orden->tiene_nicho) ? 'checked' : '' }} class="form-checkbox">
                     <label for="tiene_nicho" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                        ¿Tiene Nicho?
                    </label>
                </div>
            </div>
             {{-- Mensaje de error general para checkboxes si es necesario --}}
             @error('req_caja_paso') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
             {{-- ... errores para otros checkboxes ... --}}

 {{-- Uso Servicio (Selección) y Contacto (Selección) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                 <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="uso_servicio">Uso Servicio</label>
                     <select name="uso_servicio" id="uso_servicio" class="form-select">
                        <option value="">-- Seleccione --</option>
                        <option value="Doméstico" {{ old('uso_servicio', $orden->uso_servicio) == 'Doméstico' ? 'selected' : '' }}>Doméstico</option>
                        <option value="Comercial" {{ old('uso_servicio', $orden->uso_servicio) == 'Comercial' ? 'selected' : '' }}>Comercial</option>
                        <option value="Alumbrado Público" {{ old('uso_servicio', $orden->uso_servicio) == 'Alumbrado Público' ? 'selected' : '' }}>Alumbrado Público</option>
                        <option value="Educación" {{ old('uso_servicio', $orden->uso_servicio) == 'Educación' ? 'selected' : '' }}>Educación</option>
                        <option value="Estructura Metálica" {{ old('uso_servicio', $orden->uso_servicio) == 'Estructura Metálica' ? 'selected' : '' }}>Estructura Metálica</option>
                        <option value="Industria Ligera" {{ old('uso_servicio', $orden->uso_servicio) == 'Industria Ligera' ? 'selected' : '' }}>Industria Ligera</option>
                        <option value="Taller Mecánica" {{ old('uso_servicio', $orden->uso_servicio) == 'Taller Mecánica' ? 'selected' : '' }}>Taller Mecánica</option>
                         {{-- Añade más si es necesario --}}
                    </select>
                    @error('uso_servicio') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                </div>
                <div x-data="{ selectedContacto: '{{ old('contacto', $orden->contacto ?? '') }}' }">
                    {{-- Select de Contacto (Campo) --}}
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="contacto">
                            Contacto (Campo)
                        </label>
                        <select name="contacto" id="contacto" class="form-select @error('contacto') input-error @enderror" x-model="selectedContacto">
                            <option value="">-- Seleccione --</option>
                            <option value="cliente" {{ (old('contacto', $orden->contacto) == 'cliente') ? 'selected' : '' }}>Cliente</option>
                            <option value="hijo del cliente" {{ (old('contacto', $orden->contacto) == 'hijo del cliente') ? 'selected' : '' }}>Hijo del cliente</option>
                            <option value="sobrino del cliente" {{ (old('contacto', $orden->contacto) == 'sobrino del cliente') ? 'selected' : '' }}>Sobrino del cliente</option>
                            <option value="esposo del cliente" {{ (old('contacto', $orden->contacto) == 'esposo del cliente') ? 'selected' : '' }}>Esposo del cliente</option> {{-- Corregido typo "ciente" a "cliente" en el value si es necesario --}}
                            <option value="inquilino del cliente" {{ (old('contacto', $orden->contacto) == 'inquilino del cliente') ? 'selected' : '' }}>Inquilino del cliente</option>
                            <option value="contacto del cliente" {{ (old('contacto', $orden->contacto) == 'contacto del cliente') ? 'selected' : '' }}>Contacto del cliente</option>
                            <option value="otro" {{ (old('contacto', $orden->contacto) == 'otro') ? 'selected' : '' }}>Otro</option>
                            {{-- Añade más opciones si es necesario --}}
                        </select>
                        @error('contacto') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>
                
                    {{-- Campo condicional para "Otro Contacto" --}}
                    {{-- Se mostrará/ocultará con una transición suave --}}
                    <div x-show="selectedContacto === 'otro'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="mt-4"> {{-- Añade un margen superior cuando es visible --}}
                
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="contacto_otro">
                            Especificar Otro Contacto <span x-show="selectedContacto === 'otro'" class="text-red-500">*</span> {{-- Indicador de requerido --}}
                        </label>
                        <input class="form-input @error('contacto_otro') input-error @enderror"
                               id="contacto_otro"
                               type="text"
                               name="contacto_otro"
                               value="{{ old('contacto_otro', $orden->contacto_otro) }}"
                               placeholder="Especifique el tipo de contacto"
                               x-bind:disabled="selectedContacto !== 'otro'" {{-- Deshabilitar si no es 'otro' --}}
                               x-bind:required="selectedContacto === 'otro'"> {{-- Hacerlo 'required' en HTML5 si es 'otro' --}}
                        @error('contacto_otro') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Observación (Texto Libre) --}}
             <div class="mt-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="observacion">Observaciones (Campo)</label>
                <textarea class="form-textarea" id="observacion" name="observacion" rows="4">{{ old('observacion', $orden->observacion) }}</textarea>
                @error('observacion') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- ***** SECCIÓN SUBIDA DE FOTOGRAFÍA ***** --}}
            <hr class="my-6 border-gray-300 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Fotografía(s) de Evidencia</h3>

            {{-- Contenedor principal que manejará las vistas previas con Alpine.js --}}
            <div x-data="imageUploader()" class="mt-4">
            <label class="form-label" for="fotos_input">Seleccionar Nuevas Fotos</label>
            <input 
                type="file" 
                name="fotos[]"
                id="fotos_input" 
                class="form-input-file" 
                accept="image/jpeg,image/png,image/jpg" 
                multiple 
                @change="handleFileSelect"
            >
            <p class="mt-1 text-sm text-gray-500">Puedes seleccionar varias imágenes (máx 4).</p>
            @error('fotos') <p class="form-error-message">{{ $message }}</p> @enderror
            @error('fotos.*') <p class="form-error-message">{{ $message }}</p> @enderror

                {{-- Vista previa para las NUEVAS imágenes que se van a subir --}}
                <div x-show="images.length > 0" x-transition class="mt-4">
                <label class="form-label font-semibold">Vista Previa (Nuevas Fotos):</label>
                <div class="flex flex-wrap gap-4 mt-2 p-4 border rounded-lg bg-gray-50">
                    <template x-for="(image, index) in images" :key="index">
                        <div class="relative">
                            <img :src="image.url" class="h-24 w-24 object-cover rounded shadow">
                            <button @click.prevent="removeImage(index)" type="button" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-0.5 h-6 w-6 flex items-center justify-center text-xs font-bold">X</button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

    {{-- SECCIÓN SEPARADA E INDEPENDIENTE PARA LAS FOTOS YA GUARDADAS --}}
    <div class="mt-2">
        <div class="p-4 sm:p-8">
        <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Fotos Actuales Guardadas:</h4>
        <div class="flex flex-wrap gap-4 mt-2">
            @forelse ($orden->fotos as $foto)
                <div class="relative">
                    <a href="#" @click.prevent="$dispatch('open-modal', { imageUrl: '{{ $foto->url }}' })">
                        <img src="{{ $foto->url }}" alt="Foto de la orden" class="h-24 w-24 object-cover rounded shadow hover:opacity-80 transition-opacity">
                    </a>
                    
                    {{-- Formulario INDIVIDUAL para borrar esta foto. NO está anidado. --}}
                    <form action="{{ route('fotos_orden.destroy', $foto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta foto?');" class="absolute -top-2 -right-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Eliminar foto" class="bg-red-500 text-white rounded-full p-0.5 h-6 w-6 flex items-center justify-center text-xs font-bold">X</button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-500 italic">No hay fotos guardadas.</p>
            @endforelse
        </div>
    </div>
    </div>
            {{-- BOTONES DE ACCION --}}
            <div class="flex items-center justify-end pt-2 border-t border-gray-200 dark:border-gray-700 mt-8 space-x-3">
                <div class="mt-4">
                    <div class="p-4 sm:py-2 sm:px-8">
                    <a href="{{ route('ordenes.show', $orden) }}" class="form-button-secondary">
                        Cancelar
                    </a>
                    
                    {{-- ¡AQUÍ ESTÁ LA MAGIA! --}}
                    {{-- El atributo "form" le dice a este botón a qué formulario pertenece, --}}
                    {{-- aunque esté fuera de él en el HTML. --}}
                    <button type="submit" name="action" value="guardar_durante" form="orden-form-durante" class="form-button-success">
                        Guardar
                    </button>
                    </div>
                </div>
            </div>

</div>

{{-- Mantener el script para prevenir doble submit y manejar checkboxes si se desea --}}
@push('scripts')
<script>
    function imageUploader() {
        return {
            images: [],
            handleFileSelect(event) {
                this.images = []; 
                const files = event.target.files;
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file.type.startsWith('image/')){
                        this.images.push({
                            name: file.name,
                            url: URL.createObjectURL(file)
                        });
                    }
                }
            },
            removeImage(index) {
                this.images.splice(index, 1);
                // Forzamos al usuario a re-seleccionar para mantener la consistencia
                document.getElementById('fotos_input').value = "";
            }
        }
    }

    // Script para prevenir el doble submit en CUALQUIER formulario de la página
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                // Solo deshabilita los botones del formulario que se está enviando
                const submitButtons = this.querySelectorAll('button[type="submit"]');
                if (submitButtons.length > 0) {
                    setTimeout(() => {
                        submitButtons.forEach(button => {
                            button.disabled = true;
                            button.classList.add('opacity-50', 'cursor-not-allowed');
                            button.textContent = '...';
                        });
                    }, 50);
                }
            });
        });
    });
</script>
@endpush

@endsection 

