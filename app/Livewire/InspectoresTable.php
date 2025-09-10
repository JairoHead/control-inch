<?php

namespace App\Livewire;

use App\Models\Inspector;
use Livewire\Component;
use Livewire\WithPagination;

class InspectoresTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $searchTerm = '';
    public string $sortField = 'apellido_paterno';
    public string $sortDirection = 'asc';

    // Añadir campos válidos para ordenar (puedes ajustarlos según tu tabla de inspectores)
    protected $validSortFields = ['dni', 'nombres', 'apellido_paterno', 'apellido_materno'];


    public function updatingSearchTerm(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        // Seguridad: Asegurarse de que el campo de ordenamiento sea válido
        if (!in_array($field, $this->validSortFields)) {
            $field = 'apellido_paterno'; // Valor predeterminado seguro
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
        $query = Inspector::query();

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
                             ->orWhere('apellido_materno', 'like', $term);
                             // Añade aquí cualquier otro campo donde quieras buscar en el modelo Inspector
                             // ->orWhere('nro_colegiatura', 'like', $term); // Ejemplo si existiera
                             // ->orWhere('email', 'like', $term); // Si los inspectores tienen email
                });
            }
        }
        // --- Fin Lógica de Búsqueda ---


        // Lógica de Ordenamiento
        // Prioriza el campo principal de ordenación
        $query->orderBy($this->sortField, $this->sortDirection);

        // Luego, añade campos secundarios para desempate si no se está ordenando por ellos
        // Asegúrate de que estos campos existen en tu tabla de inspectores.
        if ($this->sortField !== 'apellido_paterno') {
            $query->orderBy('apellido_paterno', 'asc');
        }
        if ($this->sortField !== 'apellido_materno') {
            $query->orderBy('apellido_materno', 'asc');
        }
        if ($this->sortField !== 'nombres') {
            $query->orderBy('nombres', 'asc');
        }

        // Paginación
        $inspectores = $query->paginate(15);

        return view('livewire.inspectores-table', [
            'inspectores' => $inspectores,
        ]);
    }
}