<div>
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
            Lista de Usuarios
        </h1>
        <a href="{{ route('admin.users.create') }}" class="form-button-primary inline-flex items-center">
            <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Nuevo Usuario
        </a>
    </div>

    <div class="mb-4">
        <input type="search" wire:model.live.debounce.300ms="searchTerm" placeholder="Buscar por Nombre o Email..." class="form-input w-full">
    </div>
    
    @if (session()->has('success')) <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div> @endif
    @if (session()->has('error')) <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">{{ session('error') }}</div> @endif

    {{-- Indicador de carga Livewire --}}
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
            <thead class="bg-blue-900 text-white dark:bg-blue-950">
                <tr>
                    <th scope="col" wire:click="sortBy('name')" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider cursor-pointer group hover:bg-blue-800 dark:hover:bg-blue-900">
                    Nombre @include('partials._sort-icon', ['field' => 'name'])
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                @forelse ($users as $user)
                    <tr class="odd:bg-gray-200 dark:odd:bg-gray-700 even:bg-white dark:even:bg-gray-800 hover:bg-blue-100 dark:hover:bg-blue-900/30" wire:loading.class="opacity-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                            <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800" title="Ver Detalles">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center text-amber-600 hover:text-amber-800" title="Editar Usuario">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-800" title="Eliminar Usuario">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>