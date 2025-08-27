<div> {{-- 1. Elemento Raíz OBLIGATORIO para Livewire --}}

    {{-- Panel/Tarjeta Blanca --}}
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
        {{-- Padding interno --}}
        <div class="p-6 sm:p-8"> {{-- 2. Div para Padding Interno --}}

            {{-- Encabezado de la Sección --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
                    Lista de Clientes
                </h1>
                {{-- Asegúrate que tus clases 'form-button-primary' estén definidas en app.css --}}
                <a href="{{ route('clientes.create') }}" class="form-button-primary inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 flex-shrink-0">
                    <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Nuevo Cliente
                </a>
            </div> {{-- Fin Encabezado Sección --}}

            {{-- Input de Búsqueda Livewire --}}
            <div class="mb-4">
                <label for="clientes-search" class="sr-only">Buscar Clientes</label>
                <input type="search" id="clientes-search"
                       wire:model.live.debounce.300ms="searchTerm"
                       placeholder="Buscar por DNI, Nombre, Apellido o Celular..."
                       class="form-input w-full"> {{-- Asegúrate que 'form-input' esté definida --}}
            </div>

             {{-- Mensajes de Sesión de Livewire --}}
             @if (session()->has('message'))
                 <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded"> {{ session('message') }} </div>
             @endif
             @if (session()->has('error'))
                  <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded"> {{ session('error') }} </div>
             @endif

            {{-- Contenedor Tabla --}}
            <div class="overflow-x-auto mt-6">
                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead class="bg-blue-900 dark:bg-blue-950">
                        <tr>
                            <th scope="col" wire:click="sortBy('dni')" class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider cursor-pointer group hover:bg-blue-800 dark:hover:bg-blue-900">
                                DNI @include('partials._sort-icon', ['field' => 'dni'])
                            </th>
                            <th scope="col" wire:click="sortBy('apellido_paterno')" class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider cursor-pointer group hover:bg-blue-800 dark:hover:bg-blue-900">
                                Nombre Completo @include('partials._sort-icon', ['field' => 'apellido_paterno'])
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider">Celular</th> {{-- Cabecera Celular --}}
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-white dark:text-gray-200 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                        {{-- Indicador de carga --}}
                        <tr wire:loading.delay class="odd:bg-gray-200 dark:odd:bg-gray-700 even:bg-white dark:even:bg-gray-800"> {{-- Añadir estilo alterno también al loading --}}
                            <td colspan="4" class="px-6 py-4 text-center"> {{-- Colspan = 4 --}}
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Cargando...</span>
                            </td>
                        </tr>
                        {{-- Filas de datos --}}
                        @forelse ($clientes as $cliente)
                            <tr class="odd:bg-gray-200 dark:odd:bg-gray-700 even:bg-white dark:even:bg-gray-800 hover:bg-blue-100 dark:hover:bg-blue-900/30" wire:key="cliente-{{ $cliente->id }}">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $cliente->dni }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $cliente->nombre_completo ?? ($cliente->nombres.' '.$cliente->apellido_paterno) }}</td>
                                {{-- Celda Celular --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $cliente->nro_celular ?? '-' }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium space-x-3">
                                    {{-- Botones con SVGs completos --}}
                                    <a href="{{ route('clientes.show', $cliente) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300" title="Ver Detalles">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                    <a href="{{ route('clientes.edit', $cliente) }}" class="inline-flex items-center text-amber-600 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-300" title="Editar Cliente">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de dar de baja a este cliente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Dar de Baja">
                                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr wire:loading.remove>
                                <td colspan="4" class="px-6 py-12 text-center"> {{-- Colspan = 4 --}}
                                    <div class="flex flex-col items-center text-gray-500 dark:text-gray-400">
                                        <svg class="h-12 w-12 text-gray-400 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        @if(strlen($searchTerm) > 0)
                                            <p>No se encontraron clientes que coincidan con "{{ $searchTerm }}".</p>
                                        @else
                                            <p>No hay clientes registrados.</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación Livewire --}}
            <div class="mt-6"> {{-- Quitado padding redundante --}}
                {{ $clientes->links() }}
            </div>

        </div> {{-- Fin Div Padding Interno --}}
    </div> {{-- Fin Panel Blanco --}}
</div> {{-- Fin Elemento Raíz --}}