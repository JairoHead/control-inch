@extends('layouts.app')

@section('content')
{{-- Contenedor con padding y centrado --}}
<div class="flex justify-center">
    <div class="w-full max-w-8xl" >
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="p-6 sm:p-8">

                <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 text-center">
                        Editar Orden #{{ $orden->id }} - Fase: Planificación (Antes)
                    </h1>
                    <p class="text-center text-gray-600 dark:text-gray-400 mt-1">Estado Actual: <span class="font-semibold">{{ $orden->estado_legible }}</span></p>
                </div>

                @include('partials.flash-messages')

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-900 dark:border-red-700 dark:text-red-300 rounded-md" role="alert">
                        {{-- ... (Bloque de errores) ... --}}
                        <div class="flex">
                            <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 dark:text-red-300 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                            <div> <p class="font-bold">¡Error de validación!</p> <ul class="mt-1 list-disc list-inside text-sm"> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul> </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('ordenes.update', $orden) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3 border-b pb-2 dark:border-gray-700">Información General</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4 mb-6">
                        {{-- Contrato, Num Insp, Fecha Insp --}}
                        <div>
                            <label class="form-label" for="contrato">Contrato <span class="text-red-500">*</span></label>
                            <select name="contrato" id="contrato" required class="form-select @error('contrato') input-error @enderror">
                                <option value="">-- Seleccione --</option>
                                <option value="Nuevo Contrato" {{ old('contrato', $orden->contrato) == 'Nuevo Contrato' ? 'selected' : '' }}>Nuevo Contrato</option>
                                <option value="AppLuz" {{ old('contrato', $orden->contrato) == 'AppLuz' ? 'selected' : '' }}>AppLuz</option>
                            </select>
                            @error('contrato') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label" for="num_insp">Número Inspección <span class="text-red-500">*</span></label>
                            <select name="num_insp" id="num_insp" required class="form-select @error('num_insp') input-error @enderror">
                                <option value="">-- Seleccione --</option>
                                <option value="1" {{ old('num_insp', $orden->num_insp) == '1' ? 'selected' : '' }}>1 (Primera Vez)</option>
                                <option value="2" {{ old('num_insp', $orden->num_insp) == '2' ? 'selected' : '' }}>2 (Segunda Visita)</option>
                            </select>
                            @error('num_insp') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label" for="fecha_insp">Fecha Inspección</label>
                            <input class="form-input @error('fecha_insp') input-error @enderror" id="fecha_insp" type="date" name="fecha_insp" value="{{ old('fecha_insp', optional($orden->fecha_insp)->format('Y-m-d')) }}">
                            @error('fecha_insp') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                        {{-- Inspector, Tipo Registro, LCL, OV --}}
                        <div>
                            <label class="form-label" for="inspector_id">Inspector Asignado <span class="text-red-500">*</span></label>
                            <select name="inspector_id" id="inspector_id" required class="form-select @error('inspector_id') input-error @enderror">
                                <option value="">-- Selecciona un Inspector --</option>
                                @foreach ($inspectores as $inspector) <option value="{{ $inspector->id }}" {{ old('inspector_id', $orden->inspector_id) == $inspector->id ? 'selected' : '' }}> {{ $inspector->nombre_completo ?? ($inspector->apellido_paterno . ' ' . $inspector->nombres) }} </option> @endforeach
                            </select>
                            @error('inspector_id') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label" for="tipo_registro">Tipo Registro</label>
                            <select name="tipo_registro" id="tipo_registro" class="form-select @error('tipo_registro') input-error @enderror">
                                <option value="">-- Seleccione --</option>
                                <option value="NORMAL" {{ old('tipo_registro', $orden->tipo_registro) == 'NORMAL' ? 'selected' : '' }}>Normal</option>
                                <option value="ACTUALIZACION" {{ old('tipo_registro', $orden->tipo_registro) == 'ACTUALIZACION' ? 'selected' : '' }}>Actualización</option>
                            </select>
                            @error('tipo_registro') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label" for="lcl">LCL</label>
                            <input class="form-input @error('lcl') input-error @enderror" id="lcl" type="text" name="lcl" value="{{ old('lcl', $orden->lcl) }}"
                            maxlength="10">
                            @error('lcl') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label" for="ov">OV</label>
                            <input class="form-input @error('ov') input-error @enderror" id="ov" type="text" name="ov" value="{{ old('ov', $orden->ov) }}"
                            maxlength="7">
                            @error('ov') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3 border-b pb-2 mt-8 dark:border-gray-700">Información del Cliente y Servicio</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                        {{-- Cliente, Dirección --}}
                        <div>
                            <label class="form-label" for="cliente_id">Cliente <span class="text-red-500">*</span></label>
                            <select name="cliente_id" id="cliente_id" required class="form-select @error('cliente_id') input-error @enderror">
                                <option value="">-- Selecciona un Cliente --</option>
                                @foreach ($clientes as $cliente) <option value="{{ $cliente->id }}" {{ old('cliente_id', $orden->cliente_id) == $cliente->id ? 'selected' : '' }}> {{ $cliente->nombre_completo }} (DNI: {{ $cliente->dni ?? 'N/A' }}) </option> @endforeach
                            </select>
                            @error('cliente_id') <p class="form-error-message">{{ $message }}</p> @enderror
                            @if($orden->cliente) <div class="mt-2"><span class="text-sm text-gray-600 dark:text-gray-400">Celular: {{ $orden->cliente->nro_celular ?? 'N/A' }}</span></div> @endif
                        </div>
                        <div>
                            <label class="form-label" for="direccion_servicio_electrico">Dirección Servicio Eléctrico</label>
                            <textarea class="form-textarea @error('direccion_servicio_electrico') input-error @enderror" id="direccion_servicio_electrico" name="direccion_servicio_electrico" rows="3">{{ old('direccion_servicio_electrico', $orden->direccion_servicio_electrico) }}</textarea>
                            @error('direccion_servicio_electrico') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    {{-- Solicitud, Cuenta, CC, Sist. Acometida --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                        <div> <label class="form-label" for="nro_solicitud">Nro. Solicitud</label> <input class="form-input @error('nro_solicitud') input-error @enderror" id="nro_solicitud" type="text" name="nro_solicitud" value="{{ old('nro_solicitud', $orden->nro_solicitud) }}"
                            maxlength="7"> 
                            @error('nro_solicitud') <p class="form-error-message">{{ $message }}</p> @enderror </div>
                        <div> <label class="form-label" for="nro_cuenta_suministro">Nro. Cuenta Suministro</label> <input class="form-input @error('nro_cuenta_suministro') input-error @enderror" id="nro_cuenta_suministro" type="text" name="nro_cuenta_suministro" value="{{ old('nro_cuenta_suministro', $orden->nro_cuenta_suministro) }}"
                            maxlength="7"> 
                            @error('nro_cuenta_suministro') <p class="form-error-message">{{ $message }}</p> @enderror </div>
                        <div> <label class="form-label" for="cc">CC</label> <input class="form-input @error('cc') input-error @enderror" id="cc" type="text" name="cc" value="{{ old('cc', $orden->cc) }}"> @error('cc') <p class="form-error-message">{{ $message }}</p> @enderror </div>
                        <div>
                            <label class="form-label" for="sistema_acometida">Sistema Acometida</label>
                            <select name="sistema_acometida" id="sistema_acometida" class="form-select @error('sistema_acometida') input-error @enderror">
                                <option value="">-- Seleccione --</option> <option value="1" {{ old('sistema_acometida', $orden->sistema_acometida) == '1' ? 'selected' : '' }}>1</option> <option value="2" {{ old('sistema_acometida', $orden->sistema_acometida) == '2' ? 'selected' : '' }}>2</option> <option value="3" {{ old('sistema_acometida', $orden->sistema_acometida) == '3' ? 'selected' : '' }}>3</option>
                            </select> @error('sistema_acometida') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                    </div>
                     {{-- Tensión, Tarifa, Tipo --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4 mb-6">
                        <div> <label class="form-label" for="tension">Tensión</label> <input class="form-input @error('tension') input-error @enderror" id="tension" type="text" name="tension" value="{{ old('tension', $orden->tension) }}"> @error('tension') <p class="form-error-message">{{ $message }}</p> @enderror </div>
                        <div> <label class="form-label" for="tarifa">Tarifa</label> <input class="form-input @error('tarifa') input-error @enderror" id="tarifa" type="text" name="tarifa" value="{{ old('tarifa', $orden->tarifa) }}"> @error('tarifa') <p class="form-error-message">{{ $message }}</p> @enderror </div>
                        <div>
                            <label class="form-label" for="tipo">Tipo</label>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') input-error @enderror">
                                <option value="">-- Seleccione --</option> 
                                <option value="NUEVO SUMINISTRO" {{ old('tipo', $orden->tipo) == 'NUEVO SUMINISTRO' ? 'selected' : '' }}>Nuevo Suministro</option> 
                                <option value="INCREMENTO" {{ old('tipo', $orden->tipo) == 'INCREMENTO' ? 'selected' : '' }}>Incremento</option> 
                                <option value="TRASLADO" {{ old('tipo', $orden->tipo) == 'TRASLADO' ? 'selected' : '' }}>Traslado</option>
                                <option value="CNX MULTIPLE" {{ old('tipo', $orden->tipo) == 'CNX MULTIPLE' ? 'selected' : '' }}>Cnx Multiple</option>
                                <option value="AFECTACION" {{ old('tipo', $orden->tipo) == 'AFECTACION' ? 'selected' : '' }}>Afectación</option> 
                            </select> @error('tipo') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    {{-- Suministro Aledaño, Referencia --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                        <div> <label class="form-label" for="suministro_aledaño">Suministro Aledaño</label> <input class="form-input @error('suministro_aledaño') input-error @enderror" id="suministro_aledaño" type="text" name="suministro_aledaño" value="{{ old('suministro_aledaño', $orden->suministro_aledaño) }}"> @error('suministro_aledaño') <p class="form-error-message">{{ $message }}</p> @enderror </div>
                        <div> <label class="form-label" for="referencia">Referencia</label> <textarea class="form-textarea @error('referencia') input-error @enderror" id="referencia" name="referencia" rows="2">{{ old('referencia', $orden->referencia) }}</textarea> @error('referencia') <p class="form-error-message">{{ $message }}</p> @enderror </div>
                    </div>
                    {{-- SED, Alimentador --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                        <div> <label class="form-label" for="sed">SED</label> <input class="form-input @error('sed') input-error @enderror" id="sed" type="text" name="sed" value="{{ old('sed', $orden->sed) }}"> @error('sed') <p class="form-error-message">{{ $message }}</p> @enderror </div>
                        <div> <label class="form-label" for="alimentador">Alimentador</label> <input class="form-input @error('alimentador') input-error @enderror" id="alimentador" type="text" name="alimentador" value="{{ old('alimentador', $orden->alimentador) }}"> @error('alimentador') <p class="form-error-message">{{ $message }}</p> @enderror </div>
                    </div>

                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3 border-b pb-2 mt-8 dark:border-gray-700">Ubicación Geográfica</h2>
                    {{-- SECCIÓN DE UBICACIÓN CON ALPINE.JS --}}
                    <div x-data="locationSelects({
                            initialDepartamento: '{{ old('departamento_id', $orden->departamento_id ?? '') }}',
                            initialProvincia: '{{ old('provincia_id', $orden->provincia_id ?? '') }}',
                            initialDistrito: '{{ old('distrito_id', $orden->distrito_id ?? '') }}',
                            departamentosData: {{ Js::from($departamentos) }}
                        })"
                         x-init="initLocation()"
                         class="grid red:grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4 mb-6">

                         {{-- Departamento --}}
                         <div>
                            <label class="form-label" for="departamento_id">Departamento</label>
                            <select name="departamento_id" id="departamento_id"
                                    x-model="selectedDepartamento"
                                    @change="fetchProvincias()"
                                    class="form-select @error('departamento_id') input-error @enderror">
                                <option value="">-- Seleccione Departamento --</option>
                                <template x-for="depto in departamentos" :key="depto.id">
                                    <option :value="depto.id" x-text="depto.nombre"></option>
                                </template>
                            </select>
                            @error('departamento_id') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>

                        {{-- Provincia --}}
                        <div>
                            <label class="form-label" for="provincia_id">Provincia</label>
                             <select name="provincia_id" id="provincia_id" x-model="selectedProvincia" @change="fetchDistritos()" class="form-select @error('provincia_id') input-error @enderror" :disabled="!selectedDepartamento || provinciasLoading || provincias.length === 0">
                                <option value="">-- Seleccione Provincia --</option>
                                <template x-if="provinciasLoading"><option value="" disabled>Cargando...</option></template>
                                <template x-for="prov in provincias" :key="prov.id">
                                    <option :value="prov.id" x-text="prov.nombre"></option>
                                </template>
                             </select>
                            @error('provincia_id') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>

                        {{-- Distrito --}}
                        <div>
                            <label class="form-label" for="distrito_id">Distrito</label>
                             <select name="distrito_id" id="distrito_id" x-model="selectedDistrito" class="form-select @error('distrito_id') input-error @enderror" :disabled="!selectedProvincia || distritosLoading || distritos.length === 0">
                                 <option value="">-- Seleccione Distrito --</option>
                                 <template x-if="distritosLoading"><option value="" disabled>Cargando...</option></template>
                                 <template x-for="dist in distritos" :key="dist.id">
                                    <option :value="dist.id" x-text="dist.nombre"></option>
                                </template>
                             </select>
                            @error('distrito_id') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    {{-- FIN SECCIÓN UBICACIÓN --}}

                    {{-- En resources/views/ordenes/edit-durante.blade.php --}}
                {{-- ... otros campos ... --}}

                <hr class="my-6 border-gray-300 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Enlace de Ubicación (Google Maps)</h3>

                <div>
                    <label class="form-label" for="google_maps_link">Enlace Compartido de Google Maps</label>
                    <input type="url" name="google_maps_link" id="google_maps_link"
                        value="{{ old('google_maps_link', $orden->google_maps_link) }}"
                        class="form-input @error('google_maps_link') input-error @enderror"
                        placeholder="Ej: https://maps.app.goo.gl/kBHiLvGPLbuezvaX6">
                    @error('google_maps_link') <p class="form-error-message">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        En Google Maps, busca la ubicación, toca "Compartir" y copia el enlace aquí.
                        <a href="https://www.google.com/maps" target="_blank" class="text-blue-500 hover:underline">Abrir Google Maps</a>
                    </p>
                </div>

                {{-- ... resto de campos de la fase durante ... --}}

                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3 border-b pb-2 mt-8 dark:border-gray-700">Contacto Adicional</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                        {{-- Atributo, Nombre Contacto --}}
                        <div>
                            <label class="form-label" for="atributo">Atributo</label>
                            <select name="atributo" id="atributo" class="form-select @error('atributo') input-error @enderror">
                                <option value="">-- Seleccione --</option> <option value="Sr." {{ old('atributo', $orden->atributo) == 'Sr.' ? 'selected' : '' }}>Sr.</option> <option value="Sra." {{ old('atributo', $orden->atributo) == 'Sra.' ? 'selected' : '' }}>Sra.</option>
                            </select> @error('atributo') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label" for="nombre_contacto">Nombre Contacto</label>
                            <input class="form-input @error('nombre_contacto') input-error @enderror" id="nombre_contacto" type="text" name="nombre_contacto" value="{{ old('nombre_contacto', $orden->nombre_contacto) }}">
                            @error('nombre_contacto') <p class="form-error-message">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 space-x-3">
                        <a href="{{ route('ordenes.show', $orden) }}" class="form-button-secondary">
                            Cancelar
                        </a>
                        <button type="submit" name="action" value="iniciar_campo" class="form-button-success">
                            Guardar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('locationSelects', (config) => ({
            selectedDepartamento: config.initialDepartamento || '',
            selectedProvincia: config.initialProvincia || '',
            selectedDistrito: config.initialDistrito || '',

            departamentos: config.departamentosData || [],
            provincias: [],
            distritos: [],

            provinciasLoading: false,
            distritosLoading: false,

            async initLocation() {
                // Forzar selección para Departamento si es necesario
                if (this.selectedDepartamento && document.getElementById('departamento_id').value !== this.selectedDepartamento.toString()) {
                    const currentSelectedDepto = this.selectedDepartamento;
                    this.selectedDepartamento = '';
                    await Alpine.nextTick();
                    this.selectedDepartamento = currentSelectedDepto;
                }

                if (this.selectedDepartamento) {
                    await this.fetchProvincias(false);
                    await Alpine.nextTick();

                    // Forzar selección para Provincia si es necesario
                    if (this.selectedProvincia && document.getElementById('provincia_id').value !== this.selectedProvincia.toString()) {
                        const currentSelectedProv = this.selectedProvincia;
                        this.selectedProvincia = '';
                        await Alpine.nextTick();
                        this.selectedProvincia = currentSelectedProv;
                    }

                    if (this.selectedProvincia) {
                        const provinciaEsValida = this.provincias.some(p => p.id == this.selectedProvincia);
                        if (provinciaEsValida) {
                            await this.fetchDistritos(false);
                            await Alpine.nextTick();

                            // Forzar selección para Distrito si es necesario
                            if (this.selectedDistrito && document.getElementById('distrito_id').value !== this.selectedDistrito.toString()) {
                                const currentSelectedDist = this.selectedDistrito;
                                this.selectedDistrito = '';
                                await Alpine.nextTick();
                                this.selectedDistrito = currentSelectedDist;
                            }

                            const distritoEsValidoFinal = this.distritos.some(d => d.id == this.selectedDistrito);
                            if (!distritoEsValidoFinal && this.selectedDistrito !== '') {
                                this.selectedDistrito = ''; // Reset si después de todo el distrito no es válido
                            }
                        } else {
                            this.selectedProvincia = '';
                            this.selectedDistrito = '';
                            this.distritos = [];
                        }
                    }
                }
            },

            async fetchProvincias(resetChildren = true) {
                if (!this.selectedDepartamento) {
                    this.provincias = []; this.distritos = [];
                    if (resetChildren) { this.selectedProvincia = ''; this.selectedDistrito = '';}
                    return;
                }
                this.provinciasLoading = true;
                this.provincias = [];
                if (resetChildren) {
                    this.selectedProvincia = ''; this.selectedDistrito = ''; this.distritos = [];
                }
                try {
                    const response = await fetch(`/api/ubicacion/provincias/${this.selectedDepartamento}`);
                    if (!response.ok) throw new Error(`Provincias API error: ${response.status}`);
                    this.provincias = await response.json();
                } catch (error) {
                    console.error('Error fetching provincias:', error); // Mantener para errores de API
                    this.provincias = []; this.selectedProvincia = ''; this.selectedDistrito = ''; this.distritos = [];
                } finally {
                    this.provinciasLoading = false;
                }
            },

            async fetchDistritos(resetChildren = true) {
                if (!this.selectedProvincia) {
                    this.distritos = [];
                    if (resetChildren) { this.selectedDistrito = '';}
                    return;
                }
                this.distritosLoading = true;
                this.distritos = [];
                if (resetChildren) { this.selectedDistrito = ''; }
                try {
                    const response = await fetch(`/api/ubicacion/distritos/${this.selectedProvincia}`);
                    if (!response.ok) throw new Error(`Distritos API error: ${response.status}`);
                    this.distritos = await response.json();
                } catch (error) {
                    console.error('Error fetching distritos:', error); // Mantener para errores de API
                    this.distritos = []; this.selectedDistrito = '';
                } finally {
                    this.distritosLoading = false;
                }
            }
        }));
    });
</script>
@endpush