@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Encabezado con Título, Estado y Acciones Principales --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                Orden Detallada ({{ $orden->id }})
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-1">
                Estado Actual:
                <span class="font-semibold px-2 py-1 rounded text-sm
                    @switch($orden->estado)
                        @case(App\Models\Orden::ESTADO_PENDIENTE) bg-yellow-200 text-yellow-800 @break
                        @case(App\Models\Orden::ESTADO_EN_CAMPO) bg-blue-200 text-blue-800 @break
                        @case(App\Models\Orden::ESTADO_POST_CAMPO) bg-indigo-200 text-indigo-800 @break
                        @case(App\Models\Orden::ESTADO_COMPLETADA) bg-green-200 text-green-800 @break
                        @case(App\Models\Orden::ESTADO_CANCELADA) bg-red-200 text-red-800 @break
                        @default bg-gray-200 text-gray-800 @break
                    @endswitch">
                    {{ $orden->estado_legible }}
                </span>
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('ordenes.index') }}" class="form-button-secondary text-xs">
                ← Volver a Consultas
            </a>
            <a href="{{ route('ordenes.edit.antes', $orden) }}" class="form-button-primary text-xs">
                Datos de Inspección
            </a>
             <a href="{{ route('ordenes.edit.durante', $orden) }}" class="form-button-primary text-xs">
                Datos de Campo
            </a>
             <a href="{{ route('ordenes.edit.despues', $orden) }}" class="form-button-primary text-xs">
                Datos de Cierre
            </a>
             @if ($orden->esEditable())
                 <form action="{{ route('ordenes.update', $orden) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de cancelar esta orden?');">
                     @csrf
                     @method('PATCH')
                     <input type="hidden" name="action" value="cancelar_orden">
                     <button type="submit" class="form-button-danger text-xs">
                        Cancelar Orden
                    </button>
                 </form>
             @endif
        </div>
    </div>

    @include('partials.flash-messages')

    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
        <div class="px-6 py-5">

            {{-- Sección Información General y Cliente/Inspector --}}
            <div class="mb-8 pb-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Datos de Inspección</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4 text-sm">
                    <div><strong class="text-gray-500 dark:text-gray-400">Contrato:</strong> {{ $orden->contrato ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Nro. Inspección:</strong> {{ $orden->num_insp ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Fecha Inspección:</strong> {{ $orden->fecha_insp ? $orden->fecha_insp->format('d/m/Y') : 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Tipo Registro:</strong> {{ $orden->tipo_registro ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">LCL:</strong> {{ $orden->lcl ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">OV:</strong> {{ $orden->ov ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Inspector:</strong> {{ $orden->inspector->nombre_completo ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Cliente:</strong> {{ $orden->cliente->nombre_completo ?? 'N/A' }}</div>
                    <div>
                        <strong class="text-gray-500 dark:text-gray-400">Celular Cliente:</strong> 
                        @if($orden->cliente->nro_celular)
                            <a href="tel:{{ $orden->cliente->nro_celular }}" 
                            class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline transition-colors duration-200">
                                {{ $orden->cliente->nro_celular }}
                            </a>
                        @else
                            <span class="text-gray-400">N/A</span>
                        @endif
                    </div>                    <div><strong class="text-gray-500 dark:text-gray-400">Contacto Designado:</strong> {{ $orden->nombre_contacto ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Atributo:</strong> {{ $orden->atributo ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">CC:</strong> {{ $orden->cc ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Departamento:</strong> {{ $orden->departamento->nombre ?? ($orden->departamento->departamento ?? 'N/A') }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Provincia:</strong> {{ $orden->provincia->nombre ?? ($orden->provincia->provincia ?? 'N/A') }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Distrito:</strong> {{ $orden->distrito->nombre ?? ($orden->distrito->distrito ?? 'N/A') }}</div>

                    <div><strong class="text-gray-500 dark:text-gray-400">Dirección Servicio:</strong> {{ $orden->direccion_servicio_electrico ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Referencia:</strong> {{ $orden->referencia ?? 'N/A' }}</div>
                    @if($orden->google_maps_link)
                        <div> {{-- O la estructura de grid que estés usando (ej. md:col-span-1, lg:col-span-1, etc.) --}}
                            <strong class="text-gray-500 dark:text-gray-400">Enlace Google Maps:</strong>
                            <a href="{{ $orden->google_maps_link }}" target="_blank"
                            class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm underline inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Abrir Ubicación
                            </a>
                        </div>
                    @else
                        <div>
                            <strong class="text-gray-500 dark:text-gray-400">Enlace Google Maps:</strong>
                            <span class="text-black-400 dark:text-black-400">N/A</span>
                        </div>
                    @endif
                    <div><strong class="text-gray-500 dark:text-gray-400">Nro. Solicitud:</strong> {{ $orden->nro_solicitud ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Nro. Cuenta:</strong> {{ $orden->nro_cuenta_suministro ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Sistema Acometida:</strong> {{ $orden->sistema_acometida ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Tensión:</strong> {{ $orden->tension ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Tarifa:</strong> {{ $orden->tarifa ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Tipo:</strong> {{ $orden->tipo ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Suministro Aledaño:</strong> {{ $orden->suministro_aledaño ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">SED:</strong> {{ $orden->sed ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Alimentador:</strong> {{ $orden->alimentador ?? 'N/A' }}</div>
                </div>
            </div>

            {{-- Sección Datos de Campo (Fase Durante) --}}
            <div class="mb-8 pb-4 border-b border-gray-200 dark:border-gray-700">
                {{-- ... (contenido sin cambios) ... --}}
                 <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Datos de Campo</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4 text-sm">
                    <div><strong class="text-gray-500 dark:text-gray-400">Tipo Trabajo:</strong> {{ $orden->tipo_trabajo ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Pago Proyecto:</strong> {{ $orden->pago_proyecto ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Ancho Pasaje:</strong> {{ $orden->ancho_pasaje ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400"># Poste:</strong> {{ $orden->num_poste ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Dist. Murete-Pto.Venta:</strong> {{ $orden->dist_murete_pto_venta ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Dist. Predio-Pto.Venta:</strong> {{ $orden->dist_predio_pto_venta ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Dist. Predio-Pasaje:</strong> {{ $orden->dist_predio_pasaje ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Centro Poblado:</strong> {{ $orden->cp ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Cantidad de Suministros</strong> {{ $orden->cantidad_suministros ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Suministro Existente:</strong> {{ $orden->suministro_existente ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Suministro Izquierdo:</strong> {{ $orden->suministro_izquierdo ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Suministro Derecho:</strong> {{ $orden->suministro_derecho ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Nro. Medidor:</strong> {{ $orden->nro_medidor ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Fecha Instalación:</strong> {{ $orden->fecha_instalacion ? $orden->fecha_instalacion->format('d/m/Y') : 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Ubicación Medidor:</strong> {{ $orden->ubicacion_medidor ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Tipo Acometida:</strong> {{ $orden->tipo_acometida ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Ubicación Medidor:</strong> {{ $orden->ubicacion_medidor ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Req. Caja Paso:</strong> {{ $orden->req_caja_paso ? 'Sí' : 'No' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Req. Permiso Mun.:</strong> {{ $orden->req_permiso_mun ? 'Sí' : 'No' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Req. Coord. Entidad:</strong> {{ $orden->req_coord_entidad ? 'Sí' : 'No' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Incumplimiento DMS:</strong> {{ $orden->incumplimiento_dms ? 'Sí' : 'No' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Uso Servicio:</strong> {{ $orden->uso_servicio ?? 'N/A' }}</div>
                    <div><strong class="text-gray-500 dark:text-gray-400">Contacto:</strong>
                        <span class="data-value">
                            {{ Str::ucfirst($orden->contacto) ?? 'N/A' }}
                            @if($orden->contacto === 'otro' && $orden->contacto_otro)
                                ({{ $orden->contacto_otro }}) {{-- Muestra el valor especificado --}}
                            @endif
                        </span>
                    </div>

                    <div><strong class="text-gray-500 dark:text-gray-400">Tiene Nicho:</strong> {{ $orden->tiene_nicho ? 'Sí' : 'No' }}</div>
                 </div>
                 <div class="mt-4">
                    <strong class="block text-gray-500 dark:text-gray-400 text-sm">Observaciones:</strong>
                    <p class="text-gray-800 dark:text-gray-200 text-sm whitespace-pre-wrap">{{ $orden->observacion ?? 'Sin observaciones' }}</p>
                </div>
                {{-- ===================================================================== --}}
                {{-- ========= INICIO: SECCIÓN DE FOTO CON EL MÉTODO ESTÁNDAR ============== --}}
                {{-- ===================================================================== --}}
                <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">
                    Fotografía(s) de Evidencia:
                </h3>
                
                <div class="flex flex-wrap gap-4 mt-2">
                    {{-- Usamos un bucle @forelse para iterar sobre la nueva relación 'fotos' --}}
                    @forelse ($orden->fotos as $foto)
                        <div class="relative">
                            {{-- Cada foto abre el modal con su propia URL --}}
                            <a href="#" @click.prevent="$dispatch('open-modal', { imageUrl: '{{ $foto->url }}' })" title="Ver imagen completa">
                                <img src="{{ $foto->url }}" 
                                    alt="Foto de la orden #{{ $orden->id }}" 
                                    class="h-32 w-32 object-cover rounded-lg shadow-md hover:opacity-80 transition-opacity">
                            </a>
                        </div>
                    @empty
                        {{-- Esto se muestra si no hay ninguna foto asociada a la orden --}}
                        <p class="text-sm text-gray-500 italic">No hay fotos guardadas para esta orden.</p>
                    @endforelse
                </div>
            </div>
                {{-- =================================================================== --}}
                {{-- ========= FIN: SECCIÓN DE FOTO CON EL MÉTODO ESTÁNDAR ============= --}}
                {{-- =================================================================== --}}
            
            </div>

                        {{-- Sección Datos de Cierre (Fase Despues) - SIEMPRE VISIBLE --}}
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Datos de Cierre</h2>
           
                            {{-- Sub-sección: Datos Generales de Cierre (los que ya tenías) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4 text-sm mb-6">
                               <div><strong class="data-label">Fecha Drive Satel:</strong> <span class="data-value">{{ $orden->fecha_drive_satel ? $orden->fecha_drive_satel->format('d/m/Y') : 'N/A' }}</span></div>
                               <div><strong class="data-label">Fecha SCM:</strong> <span class="data-value">{{ $orden->fecha_scm ? $orden->fecha_scm->format('d/m/Y') : 'N/A' }}</span></div>
                               <div><strong class="data-label">Cable Matriz:</strong> <span class="data-value">{{ $orden->cable_matriz ?? 'N/A' }}</span></div>
                               <div><strong class="data-label">Predio en Conc. Eléctrica:</strong> <span class="data-value">{{ $orden->predio_dentro_conc_elect ? 'Sí' : 'No' }}</span></div>
                               <div><strong class="data-label">Predio en Zona Arqueológica:</strong> <span class="data-value">{{ $orden->predio_zona_arqueologica ? 'Sí' : 'No' }}</span></div>
                           </div>
           
                           {{-- Sub-sección: LLAVE (condicional) --}}
                           @if($orden->llave || $orden->llave_base_fus || $orden->llave_ir_valor)
                           <h3 class="text-md font-semibold text-gray-600 dark:text-gray-400 mt-4 mb-2">
                               LLAVE - <span class="text-blue-600 dark:text-blue-400 font-bold">{{ $orden->llave ?? 'N/D' }}</span>
                           </h3>
                           <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4 text-sm mb-6 pl-4 border-l-2 border-gray-300 dark:border-gray-600 py-2">
                               <div><strong class="data-label">Base Fus:</strong> <span class="data-value">{{ $orden->llave_base_fus ?? 'N/A' }}</span></div>
                               <div><strong class="data-label">Fusible:</strong> <span class="data-value">{{ $orden->llave_fusible ?? 'N/A' }}</span></div>
                               <div><strong class="data-label">Cable (Llave):</strong> <span class="data-value">{{ $orden->llave_cable ?? 'N/A' }}</span></div>
                               <div><strong class="data-label">In:</strong> <span class="data-value">{{ $orden->llave_in ?? 'N/A' }}</span></div>
                               <div><strong class="data-label">Iadm:</strong> <span class="data-value">{{ $orden->llave_iadm ?? 'N/A' }}</span></div>
                               <div><strong class="data-label">Ir:</strong> <span class="data-value">{{ isset($orden->llave_ir_valor) ? number_format($orden->llave_ir_valor, 1) . ' A' : 'N/A' }}</span></div>
                               <div><strong class="data-label">Ic:</strong> <span class="data-value">{{ isset($orden->llave_ic_valor) ? number_format($orden->llave_ic_valor, 1) . ' A' : 'N/A' }}</span></div>
                               <div><strong class="data-label">Ip (Calculado):</strong> <span class="data-value">{{ isset($orden->llave_ip_valor) ? number_format($orden->llave_ip_valor, 1) . ' A' : 'N/A' }}</span></div>
                           </div>
                           @endif
           
                           {{-- Sub-sección: TRAFO (condicional) --}}
                           @if($orden->codigo_trafo || $orden->trafo_pta || $orden->trafo_dmr_valor)
                           <h3 class="text-md font-semibold text-gray-600 dark:text-gray-400 mt-4 mb-2">
                               TRAFO - <span class="text-blue-600 dark:text-blue-400 font-bold">{{ $orden->codigo_trafo ?? 'N/D' }}</span>
                           </h3>
                           <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4 text-sm mb-6 pl-4 border-l-2 border-gray-300 dark:border-gray-600 py-2">
                               <div><strong class="data-label">Pta:</strong> <span class="data-value">{{ $orden->trafo_pta ?? 'N/A' }}</span></div>
                               <div><strong class="data-label">DMr:</strong> <span class="data-value">{{ isset($orden->trafo_dmr_valor) ? number_format($orden->trafo_dmr_valor, 2) . ' kVA' : 'N/A' }}</span></div>
                               <div><strong class="data-label">Lc:</strong> <span class="data-value">{{ isset($orden->trafo_lc_valor) ? number_format($orden->trafo_lc_valor, 2) . ' kVA' : 'N/A' }}</span></div>
                               <div><strong class="data-label">DMp (Calculado):</strong> <span class="data-value">{{ isset($orden->trafo_dmp_valor) ? number_format($orden->trafo_dmp_valor, 2) . ' kVA' : 'N/A' }}</span></div>
                               <div><strong class="data-label">Vr:</strong> <span class="data-value">{{ $orden->trafo_vr ?? 'N/A' }}</span></div>
                           </div>
                           @endif
           
                           {{-- Descripción Final Trabajo --}}
                           <div class="mt-4">
                               <strong class="block data-label text-sm">Descripción Final Trabajo:</strong>
                               @if($orden->descripcion_trabajo)
                                   <p class="data-value text-sm whitespace-pre-wrap">{{ $orden->descripcion_trabajo }}</p>
                               @else
                                   <p class="data-value text-sm italic text-gray-500 dark:text-gray-400">Sin descripción.</p>
                               @endif
                           </div>
                       </div>

        </div>
    </div>

</div>

{{-- ================================================= --}}
{{--        INICIO: MODAL PARA VISUALIZAR FOTO         --}}
{{-- ================================================= --}}
<div 
    x-data="{ showModal: false, imageUrl: '' }"
    x-show="showModal"
    x-on:open-modal.window="showModal = true; imageUrl = $event.detail.imageUrl;"
    x-on:keydown.escape.window="showModal = false"
    style="display: none;"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
    >
    {{-- Fondo oscuro --}}
    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/75" @click="showModal = false"></div>

    {{-- Contenido del Modal --}}
    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-4xl max-h-full overflow-auto">
        
        {{-- Botón para cerrar --}}
        <button @click="showModal = false" class="absolute -top-2 -right-2 z-10 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        {{-- La imagen en grande --}}
        <img :src="imageUrl" alt="Fotografía de evidencia en tamaño completo" class="w-full h-auto object-contain">
    </div>
</div>
{{-- ================================================= --}}
{{--          FIN: MODAL PARA VISUALIZAR FOTO          --}}
{{-- ================================================= --}}

@endsection