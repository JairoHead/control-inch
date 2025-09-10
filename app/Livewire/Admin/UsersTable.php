<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind'; // Opcional: para usar estilos de paginación de Tailwind

    public string $searchTerm = '';
    public string $sortField = 'name'; // Campo por defecto para ordenar usuarios
    public string $sortDirection = 'asc';

    // Definir los campos válidos para ordenar (ajústalos según tu tabla de users)
    protected $validSortFields = ['name', 'email', 'created_at'];


    // Resetear paginación al buscar
    public function updatingSearchTerm(): void
    {
        $this->resetPage();
    }

    // Cambiar ordenamiento
    public function sortBy(string $field): void
    {
        // Seguridad: Asegurarse de que el campo de ordenamiento sea válido
        if (!in_array($field, $this->validSortFields)) {
            $field = 'name'; // Valor predeterminado seguro
        }

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field; // Establece el nuevo campo
            $this->sortDirection = 'asc'; // Reinicia la dirección a 'asc' al cambiar de campo
        }
        $this->resetPage();
    }


    public function render()
    {
        $query = User::query();

        // --- Lógica de Búsqueda Flexible "todas las palabras en cualquier campo" ---
        if (strlen($this->searchTerm) >= 1) {
            // Dividir el término de búsqueda en palabras individuales
            $searchTerms = preg_split('/\s+/', $this->searchTerm, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($searchTerms as $term) {
                $term = '%' . $term . '%'; // Añadir comodines para cada palabra

                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('name', 'like', $term)
                             ->orWhere('email', 'like', $term);
                             // Puedes añadir más campos aquí para buscar en tu tabla de usuarios
                             // ->orWhere('id', 'like', $term); // Si quieres buscar por ID
                             // ->orWhere('some_other_column', 'like', $term);
                });
            }
        }
        // --- Fin Lógica de Búsqueda ---

        // Lógica de Ordenamiento
        // Prioriza el campo principal de ordenación
        $query->orderBy($this->sortField, $this->sortDirection);

        // Añadir campos secundarios para desempate si no se está ordenando por ellos
        // (Ajusta esto según lo que tenga más sentido para tus usuarios)
        if ($this->sortField !== 'name') {
            $query->orderBy('name', 'asc');
        }
        if ($this->sortField !== 'email') {
            $query->orderBy('email', 'asc');
        }


        $users = $query->paginate(15);

        return view('livewire.admin.users-table', [
            'users' => $users
        ]);
    }
}