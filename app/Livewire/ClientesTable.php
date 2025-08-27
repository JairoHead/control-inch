<?php

namespace App\Livewire;

use App\Models\Cliente; // <-- Cambiado a Cliente
use Livewire\Component;
use Livewire\WithPagination;

class ClientesTable extends Component // <-- Nombre de clase cambiado
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $searchTerm = '';
    public string $sortField = 'apellido_paterno'; // Ordenar por apellido por defecto
    public string $sortDirection = 'asc';

    // Escucha por evento para refrescar (si creas/editas clientes con Livewire más adelante)
    // protected $listeners = ['clienteUpdated' => '$refresh'];

    public function updatingSearchTerm(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        // Permitir ordenar por campos relacionados (si fuera necesario en el futuro)
        // if (str_contains($field, '.')) {
        //     // Lógica para ordenar por relación
        // } else {
             $this->sortField = $field;
        // }
        $this->resetPage();
    }

    public function render()
    {
        $query = Cliente::query(); // <-- Cambiado a Cliente

        // Búsqueda en campos de Cliente
        $query->when(strlen($this->searchTerm) >= 1, function ($q) {
            $term = '%' . $this->searchTerm . '%';
            return $q->where(function ($subQuery) use ($term) {
                $subQuery->where('dni', 'like', $term)
                         ->orWhere('nombres', 'like', $term)
                         ->orWhere('apellido_paterno', 'like', $term)
                         ->orWhere('apellido_materno', 'like', $term)
                         ->orWhere('nro_celular', 'like', $term); // <-- Añadido celular a la búsqueda
            });
        });

        // Ordenamiento (verifica si estos campos existen en tu tabla clientes)
        $query->orderBy($this->sortField, $this->sortDirection);
        if ($this->sortField !== 'apellido_materno') {
            $query->orderBy('apellido_materno', $this->sortDirection === 'asc' ? 'asc' : 'desc');
        }
         if ($this->sortField !== 'nombres') {
            $query->orderBy('nombres', $this->sortDirection === 'asc' ? 'asc' : 'desc');
        }

        // Paginación
        $clientes = $query->paginate(15); // <-- Cambiado a $clientes

        return view('livewire.clientes-table', [ // <-- Apunta a la nueva vista livewire
            'clientes' => $clientes, // <-- Pasa la variable $clientes
        ]);
    }
}