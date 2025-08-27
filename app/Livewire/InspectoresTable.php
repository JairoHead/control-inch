<?php

namespace App\Livewire;

use App\Models\Inspector;
use Livewire\Component;
use Livewire\WithPagination; // Importar

class InspectoresTable extends Component
{
    use WithPagination; // Usar

    protected $paginationTheme = 'tailwind'; // Para usar estilos de paginación de Tailwind

    public string $searchTerm = ''; // Cambiado a tipo string explícito (PHP 7.4+)
    public string $sortField = 'apellido_paterno';
    public string $sortDirection = 'asc';

    // Resetear paginación al buscar
    public function updatingSearchTerm(): void // Añadir tipo de retorno void (PHP 7.1+)
    {
        $this->resetPage();
    }

    // Cambiar ordenamiento
    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
        $this->resetPage();
    }

    public function render()
    {
        $query = Inspector::query();

        // Búsqueda
        $query->when(strlen($this->searchTerm) >= 1, function ($q) { // Buscar solo si hay algo escrito
            $term = '%' . $this->searchTerm . '%';
            return $q->where(function ($subQuery) use ($term) {
                $subQuery->where('dni', 'like', $term)
                         ->orWhere('nombres', 'like', $term)
                         ->orWhere('apellido_paterno', 'like', $term)
                         ->orWhere('apellido_materno', 'like', $term);
            });
        });

        // Ordenamiento
        $query->orderBy($this->sortField, $this->sortDirection);
        if ($this->sortField !== 'apellido_materno') { // Orden secundario
            $query->orderBy('apellido_materno', $this->sortDirection === 'asc' ? 'asc' : 'desc');
        }
        if ($this->sortField !== 'nombres') { // Orden terciario
            $query->orderBy('nombres', $this->sortDirection === 'asc' ? 'asc' : 'desc');
        }

        // Paginación
        $inspectores = $query->paginate(15);

        return view('livewire.inspectores-table', [
            'inspectores' => $inspectores,
        ]);
    }
}