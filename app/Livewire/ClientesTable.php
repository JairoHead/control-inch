<?php

namespace App\Livewire;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class ClientesTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $searchTerm = '';
    public string $sortField = 'apellido_paterno';
    public string $sortDirection = 'asc';

    protected $validSortFields = ['dni', 'nombres', 'apellido_paterno', 'apellido_materno', 'nro_celular'];

    public function updatingSearchTerm(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if (!in_array($field, $this->validSortFields)) {
            $field = 'apellido_paterno';
        }

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function render()
    {
        $query = Cliente::query();

        // --- Lógica de Búsqueda Flexible "todas las palabras en cualquier campo" ---
        if (strlen($this->searchTerm) >= 1) {
            // Dividir el término de búsqueda en palabras individuales
            $searchTerms = preg_split('/\s+/', $this->searchTerm, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($searchTerms as $term) {
                $term = '%' . $term . '%'; // Añadir comodines para cada palabra

                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('dni', 'like', $term)
                             ->orWhere('nombres', 'like', $term)
                             ->orWhere('apellido_paterno', 'like', $term)
                             ->orWhere('apellido_materno', 'like', $term)
                             ->orWhere('nro_celular', 'like', $term);
                             // Añade aquí cualquier otro campo donde quieras buscar
                             // ->orWhere('email', 'like', $term);
                });
            }
        }
        // --- Fin Lógica de Búsqueda ---


        // Lógica de Ordenamiento
        $query->orderBy($this->sortField, $this->sortDirection);

        if ($this->sortField !== 'apellido_paterno') {
            $query->orderBy('apellido_paterno', 'asc');
        }
        if ($this->sortField !== 'apellido_materno') {
            $query->orderBy('apellido_materno', 'asc');
        }
        if ($this->sortField !== 'nombres') {
            $query->orderBy('nombres', 'asc');
        }

        $clientes = $query->paginate(15);

        return view('livewire.clientes-table', [
            'clientes' => $clientes,
        ]);
    }
}