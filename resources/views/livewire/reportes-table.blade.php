<div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
    <div class="p-6 sm:p-8">

        {{-- Encabezado de la Sección --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
                Historial de Reportes
            </h1>
        </div>

        {{-- Panel de Filtros y Búsqueda --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
            <div class="lg:col-span-2">
                <label for="search-reportes" class="sr-only">Buscar</label>
                <input type="search" id="search-reportes" wire:model.live.debounce.300ms="searchTerm" placeholder="Buscar por Orden, Usuario, Plantilla..." class="form-input w-full">
            </div>

            <div>
                <label for="filtro-fecha" class="sr-only">Filtrar por Fecha</label>
                <select id="filtro-fecha" wire:model.live="filtroFecha" class="form-select w-full">
                    <option value="todos">Todos los tiempos</option>
                    <option value="hoy">Generados Hoy</option>
                    <option value="semana">Esta Semana</option>
                    <option value="mes">Este Mes</option>
                    <option value="rango">Rango de Fechas</option>
                </select>
            </div>
            
            <div class="lg:col-span-2" x-data="{ showRango: @entangle('filtroFecha') }">
                <div x-show="showRango === 'rango'" class="grid grid-cols-2 gap-2" x-transition>
                    <div>
                        <label for="fecha-inicio" class="text-xs text-gray-500">Desde:</label>
                        <input id="fecha-inicio" type="date" wire:model.live="fechaInicio" class="form-input w-full">
                    </div>
                    <div>
                        <label for="fecha-fin" class="text-xs text-gray-500">Hasta:</label>
                        <input id="fecha-fin" type="date" wire:model.live="fechaFin" class="form-input w-full">
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Mensaje de éxito para eliminaciones --}}
        @if (session()->has('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLA DE REPORTES --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                <thead class="bg-blue-900 dark:bg-blue-950 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Orden</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Plantilla Utilizada</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Generado por</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Fecha de Generación</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nombre del Archivo</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                    <tr wire:loading.delay.long>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Cargando...</td>
                    </tr>
                    @forelse ($reportes as $reporte)
                        <tr class="odd:bg-gray-200 dark:odd:bg-gray-700 even:bg-white dark:even:bg-gray-800 hover:bg-blue-100 dark:hover:bg-blue-900/30" wire:loading.class="opacity-50">
                            <td class="px-4 py-4 whitespace-nowrap font-medium">
                                <a href="{{ route('ordenes.show', $reporte->orden_id) }}" class="text-blue-600 dark:text-blue-400 hover:underline" title="Ver Orden #{{ $reporte->orden_id }}">
                                    #{{ $reporte->orden_id }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300" title="{{ $reporte->plantillaReporte->nombre_descriptivo ?? 'N/A' }}">
                                {{ Str::limit($reporte->plantillaReporte->nombre_descriptivo ?? 'N/A', 35) }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $reporte->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $reporte->created_at->timezone('America/Lima')->format('d/m/Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-mono" title="{{ $reporte->nombre_archivo_generado }}">
                                {{ Str::limit($reporte->nombre_archivo_generado, 40) }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                <a href="{{ route('ordenes.show', $reporte->orden) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800" title="Ver Orden Asociada">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <form action="{{ route('reportes.destroy', $reporte) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este registro? Esto no borra el archivo descargado, solo el historial.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-800" title="Eliminar Registro">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr wire:loading.remove>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center text-gray-500 dark:text-gray-400">
                                    <svg class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    <p class="font-semibold">No se encontraron reportes</p>
                                    <p class="text-sm">Intenta ajustar los filtros de búsqueda o de fecha.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $reportes->links() }}
        </div>
    </div>
</div>