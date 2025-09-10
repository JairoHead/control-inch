<?php

namespace App\Livewire;

use App\Models\Orden;
use App\Models\Cliente;
use App\Models\Inspector;
use Livewire\Component;
use Livewire\WithPagination;

class OrdenesTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $searchTerm = '';
    public string $sortField = 'id';
    public string $sortDirection = 'desc';

    // Campos válidos para ordenamiento
    protected $validSortFields = ['id', 'num_insp', 'ov', 'lcl', 'estado', 'created_at', 'updated_at'];

    public function updatingSearchTerm(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if (!in_array($field, $this->validSortFields)) {
            $field = 'id';
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
        $query = Orden::query()
                      ->with(['cliente', 'inspector']);

        // --- Lógica de Búsqueda Flexible "todas las palabras en cualquier campo" ---
        if (strlen($this->searchTerm) >= 1) {
            // Dividir el término de búsqueda en palabras individuales
            $searchTerms = preg_split('/\s+/', $this->searchTerm, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($searchTerms as $term) {
                $term = '%' . $term . '%';

                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('id', 'like', $term)
                             ->orWhere('num_insp', 'like', $term)
                             ->orWhere('ov', 'like', $term)
                             ->orWhere('lcl', 'like', $term)
                             ->orWhere('estado', 'like', $term)
                             // Búsqueda en cliente por nombres y apellidos
                             ->orWhereHas('cliente', function ($clienteQuery) use ($term) {
                                 $clienteQuery->where('nombres', 'like', $term)
                                              ->orWhere('apellido_paterno', 'like', $term)
                                              ->orWhere('apellido_materno', 'like', $term);
                             })
                             // Búsqueda en inspector por nombres y apellidos
                             ->orWhereHas('inspector', function ($inspectorQuery) use ($term) {
                                 $inspectorQuery->where('nombres', 'like', $term)
                                                ->orWhere('apellido_paterno', 'like', $term)
                                                ->orWhere('apellido_materno', 'like', $term);
                             });
                });
            }
        }
        // --- Fin Lógica de Búsqueda ---

        // Lógica de Ordenamiento
        $query->orderBy($this->sortField, $this->sortDirection);

        if ($this->sortField !== 'id') {
            $query->orderBy('id', 'desc');
        }
        if ($this->sortField !== 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        $ordenes = $query->paginate(15);

        return view('livewire.ordenes-table', [
            'ordenes' => $ordenes,
        ]);
    }
}