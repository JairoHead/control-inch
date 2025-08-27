<?php

namespace App\Livewire;

use App\Models\Orden;
use App\Models\Cliente;   // Necesario para eager loading
use App\Models\Inspector; // Necesario para eager loading
use Livewire\Component;
use Livewire\WithPagination;

class OrdenesTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $searchTerm = '';
    public string $sortField = 'id'; // Ordenar por ID por defecto
    public string $sortDirection = 'desc'; // Mostrar las más recientes primero por defecto

    // Podrías añadir listeners si editas/creas órdenes con modales Livewire más adelante
    // protected $listeners = ['ordenUpdated' => '$refresh'];

    public function updatingSearchTerm(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        // No permitir ordenar por campos de relaciones directamente (requiere más configuración)
        if (in_array($field, ['cliente.nombre_completo', 'inspector.nombre_completo'])) {
             // Podrías implementar lógica JOIN o calculada aquí si es necesario
             // Por ahora, simplemente no cambiamos el orden si se hace clic en esas columnas
             return;
         }

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
        $query = Orden::query()
                      ->with(['cliente', 'inspector']); // Eager load para eficiencia

        // Búsqueda
        $query->when(strlen($this->searchTerm) >= 1, function ($q) {
            $term = '%' . $this->searchTerm . '%';
            return $q->where(function ($subQuery) use ($term) {
                $subQuery->where('id', 'like', $term) // Buscar por ID
                         ->orWhere('num_insp', 'like', $term) // Buscar por # Insp
                         ->orWhere('contrato', 'like', $term) // Buscar por Contrato
                         // Buscar en relaciones (un poco más avanzado, requiere joins o whereHas)
                         ->orWhereHas('cliente', function ($clienteQuery) use ($term) {
                             $clienteQuery->where('nombres', 'like', $term)
                                          ->orWhere('apellido_paterno', 'like', $term)
                                          ->orWhere('apellido_materno', 'like', $term)
                                          ->orWhere('dni', 'like', $term);
                         })
                         ->orWhereHas('inspector', function ($inspectorQuery) use ($term) {
                             $inspectorQuery->where('nombres', 'like', $term)
                                            ->orWhere('apellido_paterno', 'like', $term)
                                            ->orWhere('apellido_materno', 'like', $term)
                                            ->orWhere('dni', 'like', $term);
                         });
                         // Añadir más campos si es necesario
            });
        });

        // Ordenamiento
        // Añadir lógica especial si se ordena por relaciones (más complejo)
        // Por ahora, solo ordena por campos directos de la tabla 'ordenes'
        if (!in_array($this->sortField, ['cliente.nombre_completo', 'inspector.nombre_completo'])) {
             $query->orderBy($this->sortField, $this->sortDirection);
         }
         // Añadir orden secundario por ID si no es el principal
         if ($this->sortField !== 'id') {
             $query->orderBy('id', 'desc');
         }


        // Paginación
        $ordenes = $query->paginate(15);

        return view('livewire.ordenes-table', [
            'ordenes' => $ordenes,
        ]);
    }
}