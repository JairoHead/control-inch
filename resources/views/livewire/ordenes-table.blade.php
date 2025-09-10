<div>
    {{-- Panel/Tarjeta Blanca --}}
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
        {{-- Padding interno 6 y 8--}}
        <div class="px-6 py-4 sm:px-8 sm:py-4"> 

            {{-- Encabezado de la Sección --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
                    Lista de Órdenes
                </h1>
                <a href="{{ route('ordenes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 flex-shrink-0">
                    <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Iniciar Nueva Orden
                </a>
            </div>

            {{-- Input de Búsqueda Livewire --}}
            <div class="mb-4">
                <label for="ordenes-search" class="sr-only">Buscar Órdenes</label>
                <input type="search" id="ordenes-search"
                       wire:model.live.debounce.300ms="searchTerm"
                       placeholder="Buscar por ID, #Insp, Contrato, Cliente, Inspector..."
                       class="form-input w-full">
            </div>

             {{-- Mensajes de Sesión de Livewire --}}
             @if (session()->has('message')) <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded"> {{ session('message') }} </div> @endif
             @if (session()->has('error')) <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded"> {{ session('error') }} </div> @endif

            {{-- Contenedor Tabla --}}
            <div class="mt-4 border border-gray-200 dark:border-gray-700 rounded-lg">

            <div class="overflow-auto" style="max-height: 70vh;">
                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead class="bg-blue-900 dark:bg-blue-950 sticky top-0 z-10">
                        <tr>
                            <th scope="col" wire:click="sortBy('id')" class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider cursor-pointer group hover:bg-blue-800 dark:hover:bg-blue-900">
                                ID @include('partials._sort-icon', ['field' => 'id'])
                            </th>
                            <th scope="col" wire:click="sortBy('num_insp')" class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider cursor-pointer group hover:bg-blue-800 dark:hover:bg-blue-900">
                                Nro. Insp. @include('partials._sort-icon', ['field' => 'num_insp'])
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider">
                                ov 
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider">
                                lcl 
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider">
                                Cliente
                            </th>
                             <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider">
                                Inspector
                            </th>
                            {{--<th scope="col" wire:click="sortBy('fecha_insp')" class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider cursor-pointer group hover:bg-blue-800 dark:hover:bg-blue-900">
                                Fecha Insp. @include('partials._sort-icon', ['field' => 'fecha_insp'])
                            </th>--}}
                            <th scope="col" wire:click="sortBy('estado')" class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider cursor-pointer group hover:bg-blue-800 dark:hover:bg-blue-900">
                                Estado @include('partials._sort-icon', ['field' => 'estado'])
                            </th>
                                @if(auth()->user()->role === 'admin')
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider">Creado</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider">Actualizado</th>
                                @endif
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                        <tr wire:loading.delay class="odd:bg-gray-200 dark:odd:bg-gray-700 even:bg-white dark:even:bg-gray-800">
                            <td colspan="9" class="px-6 py-4 text-center">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Cargando...</span>
                            </td>
                        </tr>
                        @forelse ($ordenes as $orden)
                            <tr class="odd:bg-gray-200 dark:odd:bg-gray-700 even:bg-white dark:even:bg-gray-800 hover:bg-blue-100 dark:hover:bg-blue-900/30" wire:key="orden-{{ $orden->id }}">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $orden->id }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $orden->num_insp }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $orden->ov }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $orden->lcl }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate" title="{{ $orden->cliente->nombre_completo ?? 'N/A' }}">
                                    {{ $orden->cliente->nombre_completo ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate" title="{{ $orden->inspector->nombre_completo ?? 'N/A' }}">
                                    {{ $orden->inspector->nombre_completo ?? 'N/A' }}</td>
                                {{--<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $orden->fecha_insp ? $orden->fecha_insp->format('d/m/Y') : '-' }}</td>--}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    <span class="font-semibold px-2 py-0.5 rounded text-xs leading-loose
                                        @switch($orden->estado)
                                            @case(App\Models\Orden::ESTADO_PENDIENTE) bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100 @break
                                            @case(App\Models\Orden::ESTADO_EN_CAMPO) bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 @break
                                            @case(App\Models\Orden::ESTADO_POST_CAMPO) bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100 @break
                                            @case(App\Models\Orden::ESTADO_COMPLETADA) bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 @break
                                            @case(App\Models\Orden::ESTADO_CANCELADA) bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 @break
                                            @default bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100 @break
                                        @endswitch">
                                        {{ $orden->estado_legible }}
                                    </span>
                                </td>
                                    @if(auth()->user()->role === 'admin')
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                            {{ $orden->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                            {{ $orden->updated_at->diffForHumans() }}
                                        </td>
                                    @endif
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium space-x-3">
                                    
                                    <button 
                                        type="button" 
                                        x-data="{}"
                                        @click="$dispatch('open-report-modal', { 
                                            actionUrl: '{{ route('reportes.generar', $orden) }}',
                                            tipoTrabajoInicial: '{{ $orden->tipo_trabajo }}'
                                        })"
                                        class="inline-flex items-center text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300" 
                                        title="Generar Reporte">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                          <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <a href="{{ route('ordenes.show', $orden) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300" title="Ver Detalles">
                                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                    <form action="{{ route('ordenes.destroy', $orden) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta orden?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Eliminar Orden">
                                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr wire:loading.remove>
                                <td colspan="9" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center text-gray-500 dark:text-gray-400">
                                        <svg class="h-12 w-12 text-gray-400 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        @if(strlen($searchTerm) > 0)
                                            <p>No se encontraron órdenes que coincidan con "{{ $searchTerm }}".</p>
                                        @else
                                            <p>No hay órdenes registradas.</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
            <div class="mt-6">
                {{ $ordenes->links() }}
            </div>

        </div>
    </div>

    <div 
        x-data="reportModal()" 
        x-show="show" 
        @open-report-modal.window="open($event.detail.actionUrl, $event.detail.tipoTrabajoInicial)"
        x-on:keydown.escape.window="show = false"
        style="display:none;" 
        class="fixed inset-0 z-50 overflow-y-auto"
        x-cloak>
        
        <div class="flex items-center justify-center min-h-screen">
            <div x-show="show" @click="show = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-black/50"></div>
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-lg mx-4">
                
                <form :action="actionUrl" method="GET">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Generar Reporte de Orden</h3>
                    <p class="text-sm text-gray-500 mt-1">Selecciona el tipo de trabajo y la plantilla a utilizar.</p>
                    
                    <div class="mt-6">
                        <label for="tipo_trabajo_select" class="form-label">Tipo de Trabajo</label>
                        <select id="tipo_trabajo_select" x-model="tipoTrabajo" @change="fetchPlantillas()" class="form-select w-full">
                            <option value="">-- Seleccione un Tipo --</option>
                            <option value="PROYECTO">Proyecto</option>
                            <option value="RUTINA">Rutina</option>
                        </select>
                    </div>
                    
                    <div class="mt-4" x-show="tipoTrabajo">
                        <label for="plantilla_select" class="form-label">Plantilla</label>
                        <select id="plantilla_select" name="plantilla_id" class="form-select w-full" :disabled="loading || plantillas.length === 0" required>
                            <option value="">-- Seleccione una Plantilla --</option>
                            <template x-for="plantilla in plantillas" :key="plantilla.id">
                                <option :value="plantilla.id" x-text="plantilla.nombre_descriptivo"></option>
                            </template>
                        </select>
                        <p x-show="loading" class="text-sm text-gray-500 mt-1">Cargando plantillas...</p>
                    </div>
                    
                    <div class="flex justify-end mt-8 space-x-3">
                        <button type="button" @click="show = false" class="form-button-secondary">Cancelar</button>
                        <button type="submit" class="form-button-success" :disabled="!tipoTrabajo">Generar Reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function reportModal() {
        return {
            show: false,
            actionUrl: '',
            tipoTrabajo: '',
            plantillas: [],
            loading: false,

            open(url, tipoInicial) {
                this.actionUrl = url;
                this.tipoTrabajo = tipoInicial || '';
                this.plantillas = [];
                this.show = true;
                if(this.tipoTrabajo) {
                    this.fetchPlantillas();
                }
            },
            
            fetchPlantillas() {
                if (!this.tipoTrabajo) {
                    this.plantillas = [];
                    return;
                }
                this.loading = true;
                fetch(`/api/plantillas/${this.tipoTrabajo}`)
                    .then(res => res.json())
                    .then(data => {
                        this.plantillas = data;
                        this.loading = false;
                    })
                    .catch(() => {
                        this.loading = false;
                        alert('Error al cargar las plantillas.');
                    });
            }
        }
    }
</script>
@endpush