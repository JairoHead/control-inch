@extends('layouts.app') {{-- Usa tu layout principal --}}

@section('content')
<div class="flex justify-center"> {{-- 1. Contenedor para centrar --}}
    <div class="w-full max-w-8xl"> {{-- 2. Contenedor para ancho máximo (ajusta max-w-XXX según necesites) --}}
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden"> {{-- 3. El panel/tarjeta --}}
            <div class="p-6 sm:p-8"> {{-- 4. Padding interno del panel --}}

                {{-- Encabezado del formulario --}}
                <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 text-center">
                        Editar Orden #{{ $orden->id }} - Fase: Cierre
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

    <form id="orden-form-despues" action="{{ route('ordenes.update', $orden) }}" method="POST" class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PATCH')

        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4 border-b pb-2 dark:border-gray-700">Información de Cierre</h2>

        {{-- Fechas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="fecha_drive_satel">
                    Fecha Drive Satel
                </label>
                <input class="form-input" id="fecha_drive_satel" type="date" name="fecha_drive_satel" value="{{ old('fecha_drive_satel', optional($orden->fecha_drive_satel)->format('Y-m-d')) }}">
                @error('fecha_drive_satel') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="fecha_scm">
                    Fecha SCM
                </label>
                <input class="form-input" id="fecha_scm" type="date" name="fecha_scm" value="{{ old('fecha_scm', optional($orden->fecha_scm)->format('Y-m-d')) }}">
                @error('fecha_scm') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Llave (Selección) y Cable Matriz (Selección) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="cable_matriz">Cable Matriz</label>
                 {{-- CORRECCIÓN: Cambiado a select --}}
                <select name="cable_matriz" id="cable_matriz" class="form-select">
                    <option value="2x16+Pmm²" {{ old('cable_matriz', $orden->cable_matriz) == '2x16+Pmm²' ? 'selected' : '' }}>2x16+Pmm²</option>
                    <option value="3x25+Pmm²" {{ old('cable_matriz', $orden->cable_matriz) == '3x25+Pmm²' ? 'selected' : '' }}>3x25+Pmm²</option>
                    <option value="3x35+Pmm²" {{ old('cable_matriz', $orden->cable_matriz) == '3x35+Pmm²' ? 'selected' : '' }}>3x35+Pmm²</option>
                    <option value="3x50+Pmm²" {{ old('cable_matriz', $orden->cable_matriz) == '3x50+Pmm²' ? 'selected' : '' }}>3x50+Pmm²</option>
                    <option value="3x70+Pmm²" {{ old('cable_matriz', $orden->cable_matriz) == '3x70+Pmm²' ? 'selected' : '' }}>3x70+Pmm²</option>
                    <option value="3x95+Pmm²" {{ old('cable_matriz', $orden->cable_matriz) == '3x95+Pmm²' ? 'selected' : '' }}>3x95+Pmm²</option>
                    <option value="3x25+2x16+Pmm²" {{ old('cable_matriz', $orden->cable_matriz) == '3x25+2x16+Pmm²' ? 'selected' : '' }}>3x25+2x16+Pmm²</option>
                    <option value="3x35+2x16+Pmm²" {{ old('cable_matriz', $orden->cable_matriz) == '3x35+2x16+Pmm²' ? 'selected' : '' }}>3x35+2x16+Pmm²</option>
                    <option value="3x50+2x16+Pmm²" {{ old('cable_matriz', $orden->cable_matriz) == '3x50+2x16+Pmm²' ? 'selected' : '' }}>3x50+2x16+Pmm²</option>
                    <option value="3x70+2x16+Pmm²" {{ old('cable_matriz', $orden->cable_matriz) == '3x70+2x16+Pmm²' ? 'selected' : '' }}>3x70+2x16+Pmm²</option>
                    <option value="3x95+2x16+Pmm²" {{ old('cable_matriz', $orden->cable_matriz) == '3x95+2x16+Pmm²' ? 'selected' : '' }}>3x95+2x16+Pmm²</option>
                    <option value="CONCENTRICO TRIPOLAR 6mm²" {{ old('cable_matriz', $orden->cable_matriz) == 'CONCENTRICO TRIPOLAR 6mm²' ? 'selected' : '' }}>CONCENTRICO TRIPOLAR 6mm²</option>
                    <option value="CONCENTRICO TRIPOLAR 4mm²" {{ old('cable_matriz', $orden->cable_matriz) == 'CONCENTRICO TRIPOLAR 4mm²' ? 'selected' : '' }}>CONCENTRICO TRIPOLAR 4mm²</option>
                </select>
                @error('cable_matriz') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Condiciones del Predio (Checkboxes) --}}
         <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3 mt-6">Condiciones del Predio</h3>
         <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 mb-6">
             <div class="flex items-center">
                 <input type="hidden" name="predio_dentro_conc_elect" value="0">
                 <input id="predio_dentro_conc_elect" name="predio_dentro_conc_elect" type="checkbox" value="1" {{ old('predio_dentro_conc_elect', $orden->predio_dentro_conc_elect) ? 'checked' : '' }} class="form-checkbox">
                 <label for="predio_dentro_conc_elect" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                     Predio Dentro de Concesión Eléctrica
                 </label>
             </div>
              <div class="flex items-center">
                  <input type="hidden" name="predio_zona_arqueologica" value="0">
                  <input id="predio_zona_arqueologica" name="predio_zona_arqueologica" type="checkbox" value="1" {{ old('predio_zona_arqueologica', $orden->predio_zona_arqueologica) ? 'checked' : '' }} class="form-checkbox">
                  <label for="predio_zona_arquelogica" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                      Predio en Zona Arqueológica
                  </label>
                  @error('predio_zona_arquelogica') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror {{-- Mostrar error si es necesario --}}
              </div>
         </div>


    {{-- ======================================================================= --}}
    {{-- INICIO: NUEVOS CAMPOS DE LLAVE Y TRAFO CON ALPINE.JS PARA CÁLCULOS --}}
    {{-- ======================================================================= --}}
    <div class="mt-8" x-data="{
            // === Para LLAVE ===
            // Inputs directos (el usuario escribe el valor numérico)
            // Inicializar con valores numéricos, o 0 si es null/vacío para evitar NaN en cálculos
            llave_ir_valor_input: {{ old('llave_ir_valor', $orden->llave_ir_valor ?? 0) === '' ? 0 : (float)old('llave_ir_valor', $orden->llave_ir_valor ?? 0) }},
            llave_ic_valor_input: {{ old('llave_ic_valor', $orden->llave_ic_valor ?? 0) === '' ? 0 : (float)old('llave_ic_valor', $orden->llave_ic_valor ?? 0) }},
            
            // Getter para el cálculo de Ip (solo el valor numérico)
            get llave_ip_valor_calculado() {
                const ir = parseFloat(this.llave_ir_valor_input) || 0;
                const ic = parseFloat(this.llave_ic_valor_input) || 0;
                return (ir + ic).toFixed(1); // Ajusta el número de decimales si es necesario (ej. 1 para 139.2)
            },

            // === Para TRAFO ===
            // Inputs directos
            trafo_dmr_valor_input: {{ old('trafo_dmr_valor', $orden->trafo_dmr_valor ?? 0) === '' ? 0 : (float)old('trafo_dmr_valor', $orden->trafo_dmr_valor ?? 0) }},
            trafo_lc_valor_input: {{ old('trafo_lc_valor', $orden->trafo_lc_valor ?? 0) === '' ? 0 : (float)old('trafo_lc_valor', $orden->trafo_lc_valor ?? 0) }},

            // Getter para el cálculo de DMp (solo el valor numérico)
            get trafo_dmp_valor_calculado() {
                const dmr = parseFloat(this.trafo_dmr_valor_input) || 0;
                const lc = parseFloat(this.trafo_lc_valor_input) || 0;
                return (dmr + lc).toFixed(2); // Ajusta el número de decimales (ej. 2 para 149.85)
            }
        }">
        {{-- SECCIÓN LLAVE --}}
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-1 mt-6">
            LLAVE - <span class="text-blue-600 dark:text-blue-400">
                {{ $orden->llave ?? 'XX' }}
            </span>
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6 border dark:border-gray-700 p-4 rounded-md shadow-sm">
            @php
            $llaveItems = [
                ['label' => 'Base Fus', 'name' => 'llave_base_fus', 'placeholder' => 'Ej: UH-630 A', 'type' => 'text'],
                ['label' => 'Fusible', 'name' => 'llave_fusible', 'placeholder' => 'Ej: S/D A', 'type' => 'text'],
                // Modificado: 'Cable (Llave)' ahora es un select
                ['label' => 'Cable (Llave)', 'name' => 'llave_cable', 'type' => 'select', 'options' => [
                    '' => '-- Seleccione Tipo de Cable --', // Opción por defecto
                    'CABLE AL. NA2XY 0.6/1KV. 1-1x 70' => 'CABLE AL. NA2XY 0.6/1KV. 1-1x 70',
                    'CABLE AL. NA2XY 0.6/1KV. 1-1x150' => 'CABLE AL. NA2XY 0.6/1KV. 1-1x150',
                    'CABLE AL. NA2XY 0.6/1KV. 1-1x240' => 'CABLE AL. NA2XY 0.6/1KV. 1-1x240',
                    'CABLE AL. NA2XY 0.6/1KV. 1-1x400' => 'CABLE AL. NA2XY 0.6/1KV. 1-1x400',
                ]],
                ['label' => 'In', 'name' => 'llave_in', 'placeholder' => 'Ej: 417 A', 'type' => 'text'],
                ['label' => 'Iadm', 'name' => 'llave_iadm', 'placeholder' => 'Ej: 295 A', 'type' => 'text'],
            ];
            $llaveNumericItems = [
                ['label' => 'Ir', 'name' => 'llave_ir_valor', 'alpine_model' => 'llave_ir_valor_input', 'unidad' => 'A', 'placeholder' => 'Ej: 136', 'step' => 'any'],
                ['label' => 'Ic', 'name' => 'llave_ic_valor', 'alpine_model' => 'llave_ic_valor_input', 'unidad' => 'A', 'placeholder' => 'Ej: 3.2', 'step' => '0.1'],
            ];
        @endphp
        
        {{-- Bucle para renderizar los campos de $llaveItems --}}
        @foreach($llaveItems as $item)
        <div>
            <label class="form-label" for="{{ $item['name'] }}">{{ $item['label'] }}</label>
            @if($item['type'] === 'text')
                <input class="form-input @error($item['name']) input-error @enderror"
                    id="{{ $item['name'] }}"
                    type="text"
                    name="{{ $item['name'] }}"
                    value="{{ old($item['name'], $orden->{$item['name']}) }}"
                    placeholder="{{ $item['placeholder'] }}">
            @elseif($item['type'] === 'select')
                <select class="form-select @error($item['name']) input-error @enderror" {{-- Cambiado a form-select --}}
                        id="{{ $item['name'] }}"
                        name="{{ $item['name'] }}">
                    @foreach($item['options'] as $value => $display)
                        <option value="{{ $value }}" {{ old($item['name'], $orden->{$item['name']}) == $value ? 'selected' : '' }}>
                            {{ $display }}
                        </option>
                    @endforeach
                </select>
            @endif
            @error($item['name']) <p class="form-error-message">{{ $message }}</p> @enderror
        </div>
        @endforeach
        
        {{-- Bucle para renderizar los campos de $llaveNumericItems (sin cambios aquí) --}}
        @foreach($llaveNumericItems as $item)
        <div>
            <label class="form-label" for="{{ $item['name'] }}">{{ $item['label'] }}</label>
            <div class="flex items-baseline">
                <input class="form-input @error($item['name']) input-error @enderror" id="{{ $item['name'] }}" type="number"
                    step="{{ $item['step'] ?? 'any' }}" name="{{ $item['name'] }}"
                    x-model.number.debounce.500ms="{{ $item['alpine_model'] }}"
                    placeholder="{{ $item['placeholder'] }}">
                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">{{ $item['unidad'] }}</span>
            </div>
            @error($item['name']) <p class="form-error-message">{{ $message }}</p> @enderror
        </div>
        @endforeach
        
        {{-- Campo Ip (Calculado) para LLAVE (sin cambios aquí) --}}
        <div>
            <label class="form-label" for="llave_ip_valor">Ip (Ir + Ic)</label>
            <div class="flex items-baseline">
                <input class="form-input bg-gray-100 dark:bg-gray-700 @error('llave_ip_valor') input-error @enderror"
                    id="llave_ip_valor" type="number" step="any"
                    name="llave_ip_valor"
                    x-bind:value="llave_ip_valor_calculado" readonly>
                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">A</span>
            </div>
            @error('llave_ip_valor') <p class="form-error-message">{{ $message }}</p> @enderror
        </div>
        </div>

        {{-- SECCIÓN TRAFO --}}
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-1 mt-6">
            TRAFO - <span class="text-blue-600 dark:text-blue-400">
                {{ $orden->codigo_trafo ?? 'XXXXXX' }}
            </span>
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6 border dark:border-gray-700 p-4 rounded-md shadow-sm">
            @php
                $trafoItems = [
                    ['label' => 'Pta', 'name' => 'trafo_pta', 'placeholder' => 'Ej: 160 kVA'],
                    ['label' => 'Vr', 'name' => 'trafo_vr', 'placeholder' => 'Ej: 230.3 V'],
                ];
                $trafoNumericItems = [
                    ['label' => 'DMr', 'name' => 'trafo_dmr_valor', 'alpine_model' => 'trafo_dmr_valor_input', 'unidad' => 'kVA', 'placeholder' => 'Ej: 148.69', 'step' => 'any'],
                    ['label' => 'Lc', 'name' => 'trafo_lc_valor', 'alpine_model' => 'trafo_lc_valor_input', 'unidad' => 'kVA', 'placeholder' => 'Ej: 1.16', 'step' => 'any'],
                ];
            @endphp

            {{-- Campos de texto libre (valor+unidad) para TRAFO --}}
            @foreach($trafoItems as $item)
            <div>
                <label class="form-label" for="{{ $item['name'] }}">{{ $item['label'] }}</label>
                <input class="form-input @error($item['name']) input-error @enderror" id="{{ $item['name'] }}" type="text"
                    name="{{ $item['name'] }}"
                    value="{{ old($item['name'], $orden->{$item['name']}) }}"
                    placeholder="{{ $item['placeholder'] }}">
                @error($item['name']) <p class="form-error-message">{{ $message }}</p> @enderror
            </div>
            @endforeach

            {{-- Campos numéricos para TRAFO --}}
            @foreach($trafoNumericItems as $item)
            <div>
                <label class="form-label" for="{{ $item['name'] }}">{{ $item['label'] }}</label>
                <div class="flex items-baseline">
                    <input class="form-input @error($item['name']) input-error @enderror" id="{{ $item['name'] }}" type="number"
                        step="{{ $item['step'] ?? 'any' }}" name="{{ $item['name'] }}"
                        x-model.number.debounce.500ms="{{ $item['alpine_model'] }}"
                        placeholder="{{ $item['placeholder'] }}">
                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">{{ $item['unidad'] }}</span>
                </div>
                @error($item['name']) <p class="form-error-message">{{ $message }}</p> @enderror
            </div>
            @endforeach

            {{-- Campo DMp (Calculado) para TRAFO --}}
            <div>
                <label class="form-label" for="trafo_dmp_valor">DMp (DMr + Lc)</label>
                <div class="flex items-baseline">
                    <input class="form-input bg-gray-100 dark:bg-gray-700 @error('trafo_dmp_valor') input-error @enderror"
                        id="trafo_dmp_valor" type="number" step="any"
                        name="trafo_dmp_valor" {{-- Este name enviará el valor calculado al backend --}}
                        x-bind:value="trafo_dmp_valor_calculado" readonly>
                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">kVA</span>
                </div>
                @error('trafo_dmp_valor') <p class="form-error-message">{{ $message }}</p> @enderror
            </div>
        </div>


        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4 mt-8">
            Constructor de Descripción de Trabajo
        </h2>

        {{-- El contenedor principal de Alpine.js --}}
        <div x-data="descargoBuilder(
            {{ $orden->toJson() }}, 
            {{ $tiposDeDescargo->toJson() }}
        )" class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-inner space-y-4">

            {{-- Inputs ocultos para guardar los IDs de las selecciones --}}
            <input type="hidden" name="descargo_tipo_id_sel" :value="tipoId">
            <input type="hidden" name="descargo_parte1_id_sel" :value="parte1IdSeleccionado">
            <input type="hidden" name="descargo_parte2_id_sel" :value="parte2IdSeleccionado">
            <input type="hidden" name="descargo_parte3_id_sel" :value="parte3IdSeleccionado">

            {{-- SELECT 1: TIPO DE DESCARGO --}}
            <div>
                <label for="tipo_descargo_ts" class="form-label">1. Seleccione el Tipo de Descargo:</label>
                <input id="tipo_descargo_ts">
            </div>

            {{-- Contenedor para los selects dependientes --}}
            <div x-show="tipoId" x-transition class="space-y-4 mt-4">
                <div>
                    <label for="parte1_ts" class="form-label">2. Seleccione la Parte 1:</label>
                    <input id="parte1_ts">
                </div>
                <div>
                    <label for="parte2_ts" class="form-label">3. Seleccione la Parte 2:</label>
                    <input id="parte2_ts">
                </div>
                <div>
                    <label for="parte3_ts" class="form-label">4. Seleccione la Parte 3:</label>
                    <input id="parte3_ts">
                </div>
            </div>
            
            {{-- ========================================================= --}}
            {{-- ========= SECCIÓN DE TEXTAREA CORREGIDA Y ÚNICA ========= --}}
            {{-- ========================================================= --}}
            <div class="mt-6">
                <label for="descripcion_trabajo" class="form-label font-bold">Descripción Final del Trabajo</label>
                <p class="text-xs text-gray-500 mb-2">Generada automáticamente. El contenido de este campo se guardará.</p>
                
                {{-- Este es AHORA el único campo. Es la vista previa Y el dato que se envía. --}}
                <textarea 
                    id="descripcion_trabajo" 
                    name="descripcion_trabajo" 
                    x-model="descripcionFinal" 
                    rows="6" 
                    readonly 
                    class="form-textarea w-full bg-gray-200 dark:bg-gray-600 focus:ring-0 focus:border-gray-300">
                </textarea>
            </div>
            
        </div>
</div> {{-- Cierre del div x-data --}}

            {{-- Botones de Acción --}}
            <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700 mt-6 space-x-3">
                <a href="{{ route('ordenes.show', $orden) }}" class="form-button-secondary">
                    Cancelar
                </a>
                
                <button type="submit" name="action" value="completar_orden" class="form-button-success"> {{-- Cambiado a success o el color que prefieras para completar --}}
                    Completar Orden
                </button>
            </div>

        </form>
    </div>


{{-- Script para prevenir doble submit --}}
@push('scripts')
<script>
    function descargoBuilder(orden, tipos) {
        return {
            ordenData: orden,
            tipos: tipos,
            tipoId: orden.descargo_tipo_id_sel || '',
            parte1IdSeleccionado: orden.descargo_parte1_id_sel || '',
            parte2IdSeleccionado: orden.descargo_parte2_id_sel || '',
            parte3IdSeleccionado: orden.descargo_parte3_id_sel || '',
            tsTipo: null, tsParte1: null, tsParte2: null, tsParte3: null,
            descripcionFinal: orden.descripcion_trabajo || '',

            init() {
                this.tsTipo = new TomSelect('#tipo_descargo_ts', {
                    maxItems: 1, valueField: 'id', labelField: 'nombre',
                    placeholder: '-- Seleccione un Tipo --',
                    options: this.tipos,
                    items: [this.tipoId],
                    onChange: (value) => {
                        this.tipoId = value;
                        // Al cambiar el tipo, reseteamos las selecciones hijas
                        this.parte1IdSeleccionado = '';
                        this.parte2IdSeleccionado = '';
                        this.parte3IdSeleccionado = '';
                        this.cargarOpciones();
                    }
                });
                
                this.tsParte1 = this.crearTomSelect('#parte1_ts', 'parte1IdSeleccionado');
                this.tsParte2 = this.crearTomSelect('#parte2_ts', 'parte2IdSeleccionado');
                this.tsParte3 = this.crearTomSelect('#parte3_ts', 'parte3IdSeleccionado');

                if (this.tipoId) {
                    this.cargarOpciones();
                }
            },

            crearTomSelect(selector, modelo) {
                return new TomSelect(selector, {
                    maxItems: 1, valueField: 'id', labelField: 'plantilla',
                    placeholder: '-- No aplica --',
                    render: { option: (data, escape) => `<div title="${escape(data.plantilla)}">${escape(data.plantilla)}</div>` },
                    onChange: (value) => { this[modelo] = value || ''; this.actualizarDescripcion(); }
                });
            },

            // VERSIÓN ROBUSTA DE cargarOpciones
            async cargarOpciones() {
                this.tsParte1.clear(); this.tsParte1.clearOptions();
                this.tsParte2.clear(); this.tsParte2.clearOptions();
                this.tsParte3.clear(); this.tsParte3.clearOptions();

                if (!this.tipoId) {
                    this.actualizarDescripcion();
                    return;
                }
                
                try {
                    // Usamos Promise.all para hacer las peticiones en paralelo
                    const responses = await Promise.all([
                        fetch(`/api/descargos/parte1/${this.tipoId}`),
                        fetch(`/api/descargos/parte2/${this.tipoId}`),
                        fetch(`/api/descargos/parte3/${this.tipoId}`)
                    ]);
                    const [data1, data2, data3] = await Promise.all(responses.map(r => r.json()));

                    // Cargamos las opciones
                    this.tsParte1.addOptions(data1);
                    this.tsParte2.addOptions(data2);
                    this.tsParte3.addOptions(data3);
                    
                    // Y AHORA re-seleccionamos los valores. Es la parte clave.
                    this.tsParte1.setValue(this.parte1IdSeleccionado);
                    this.tsParte2.setValue(this.parte2IdSeleccionado);
                    this.tsParte3.setValue(this.parte3IdSeleccionado);

                } catch (error) {
                    console.error("Error al cargar las opciones de descargo:", error);
                }
            },

            // Construye la descripción final
            actualizarDescripcion() {
                // Obtenemos las plantillas de texto a partir de los IDs seleccionados
                const plantilla1 = this.tsParte1.options[this.parte1IdSeleccionado]?.plantilla || '';
                const plantilla2 = this.tsParte2.options[this.parte2IdSeleccionado]?.plantilla || '';
                const plantilla3 = this.tsParte3.options[this.parte3IdSeleccionado]?.plantilla || '';

                let partes = [plantilla1, plantilla2, plantilla3];
                let descripcion = partes.filter(p => p).join('');

                if (!descripcion) {
                    this.descripcionFinal = ''; // Si no hay nada seleccionado, el textarea se vacía
                    return;
                }

                // Expresión regular para encontrar todos los (PLACEHOLDERS)
                const regex = /\(([^)]+)\)/g;
                this.descripcionFinal = descripcion.replace(regex, (match, campo) => {
                    const campoMapeado = this.mapearCampo(campo.trim().toUpperCase());
                    const valor = this.ordenData[campoMapeado];
                    if (valor === null || valor === undefined || valor === '') return `(${campo})`;
                    return valor;
                });
            },
            
            // Mapea los placeholders a los nombres de columna reales de la tabla `ordenes`
            mapearCampo(placeholder) {
                const mapa = {
                    'CANT': 'cantidad_suministros', // Necesitas añadir este campo a tu tabla `ordenes`
                    'TIPO ACOM': 'tipo_acometida',
                    'SIST ACOM': 'sistema_acometida',
                    'C.C.': 'cc',
                    'N° POSTE': 'num_poste',
                    'DIST. MURETE AL PTO VENTA': 'dist_murete_pto_venta',
                    'DIST. DEL PREDIO EN EL INT. DEL PASAJE': 'dist_predio_pasaje',
                    'DIST. DEL PREDIO AL PTO DE VENTA': 'dist_predio_pto_venta',
                    'SED': 'sed',
                    'LLAVE': 'llave',
                    'ALIM.': 'alimentador',
                    'SUMIN. EXIST.': 'suministro_existente',
                    'C.P.': 'cp'
                };
                return mapa[placeholder] || placeholder.toLowerCase().replace(/\s/g, '_').replace(/\./g, '');
            }
        }
    }
    
    // Script simple para deshabilitar botones al enviar
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('orden-form-despues');
        if (form) {
            form.addEventListener('submit', function(event) {
                const submitter = event.submitter;
                const submitButtons = form.querySelectorAll('button[type="submit"]');
                
                setTimeout(() => {
                    submitButtons.forEach(button => {
                        button.disabled = true;
                        button.classList.add('opacity-50', 'cursor-not-allowed');
                        if (button === submitter) {
                            button.textContent = 'Procesando...';
                        }
                    });
                }, 50);
            });
        }
    });
</script>
@endpush

@endsection