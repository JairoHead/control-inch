<?php

namespace App\Livewire;

use App\Models\ReporteGenerado;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon; // Importar Carbon para manejar fechas

class ReportesTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind'; // Para usar estilos de paginación de Tailwind

    public string $searchTerm = '';
    public string $sortField = 'created_at'; // Ordenar por fecha de creación por defecto
    public string $sortDirection = 'desc'; // Más reciente primero por defecto

    public string $filtroFecha = 'todos'; // Opciones: 'hoy', 'semana', 'mes', 'rango', 'todos'
    public string $fechaInicio = '';
    public string $fechaFin = '';

    // Definir los campos válidos para ordenar (ajústalos según tus necesidades)
    // Para campos de relaciones, usar el nombre de la columna en la tabla principal o solo el nombre de la relación si no se ordena directamente por un campo.
    protected $validSortFields = ['nombre_archivo_generado', 'created_at'];
    // No se suelen ordenar directamente por campos de relación simples así en el componente si la relación es 1:1 o 1:M.
    // Para ordenar por campos de relación, se requiere un 'join' o una subconsulta más compleja que no está en el scope simple de sortField.
    // Por ahora, nos centraremos en campos del ReporteGenerado.

    // Resetear paginación al buscar o cambiar filtros de fecha/rango
    public function updatingSearchTerm(): void
    {
        $this->resetPage();
    }

    public function updatingFiltroFecha(): void
    {
        $this->resetPage();
    }

    public function updatingFechaInicio(): void
    {
        $this->resetPage();
    }

    public function updatingFechaFin(): void
    {
        $this->resetPage();
    }


    // Cambiar ordenamiento
    public function sortBy(string $field): void
    {
        // Seguridad: Asegurarse de que el campo de ordenamiento sea válido
        if (!in_array($field, $this->validSortFields)) {
            $field = 'created_at'; // Valor predeterminado seguro
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
        $query = ReporteGenerado::query()->with(['orden', 'user', 'plantillaReporte']);

        // --- Lógica de Búsqueda Flexible "todas las palabras en cualquier campo" ---
        if (strlen($this->searchTerm) >= 1) { // Cambié a >= 1 para búsquedas más cortas, pero puedes mantener >= 2 si prefieres
            // Dividir el término de búsqueda en palabras individuales
            $searchTerms = preg_split('/\s+/', $this->searchTerm, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($searchTerms as $term) {
                $term = '%' . $term . '%'; // Añadir comodines para cada palabra

                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('nombre_archivo_generado', 'like', $term)
                             ->orWhereHas('orden', function($sq) use ($term) {
                                 // Buscamos en el ID de la orden o algún otro campo descriptivo de la orden
                                 $sq->where('id', 'like', $term);
                                 // Si la orden tiene un campo como 'numero_orden' o 'descripcion', añádelo aquí:
                                 // ->orWhere('numero_orden', 'like', $term);
                             })
                             ->orWhereHas('user', function($sq) use ($term) {
                                 // Buscamos en el nombre del usuario
                                 $sq->where('name', 'like', $term);
                                 // Puedes añadir email si fuera relevante:
                                 // ->orWhere('email', 'like', $term);
                             })
                             ->orWhereHas('plantillaReporte', function($sq) use ($term) {
                                 // Buscamos en el nombre descriptivo de la plantilla
                                 $sq->where('nombre_descriptivo', 'like', $term);
                             });
                });
            }
        }
        // --- Fin Lógica de Búsqueda ---


        // Aplicar filtros de fecha
        switch ($this->filtroFecha) {
            case 'hoy':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'semana':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'mes':
                $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            case 'rango':
                // Asegurar que las fechas son válidas antes de aplicar el filtro
                if ($this->fechaInicio && $this->fechaFin && Carbon::parse($this->fechaInicio)->isValid() && Carbon::parse($this->fechaFin)->isValid()) {
                    // Añadir un día a la fecha fin para incluir el día completo
                    $query->whereBetween('created_at', [Carbon::parse($this->fechaInicio)->startOfDay(), Carbon::parse($this->fechaFin)->endOfDay()]);
                }
                break;
        }

        // Lógica de Ordenamiento
        // Prioriza el campo principal de ordenación
        $query->orderBy($this->sortField, $this->sortDirection);

        // Añadir campo secundario para desempate, si no se está ordenando por él
        if ($this->sortField !== 'created_at') {
            $query->orderBy('created_at', 'desc'); // Siempre ordenar por fecha descendente como desempate si no es el principal
        }


        $reportes = $query->paginate(15);

        return view('livewire.reportes-table', [
            'reportes' => $reportes
        ]);
    }
}