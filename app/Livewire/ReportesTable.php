<?php

namespace App\Livewire;

use App\Models\ReporteGenerado;
use Livewire\Component;
use Livewire\WithPagination;

class ReportesTable extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $filtroFecha = 'todos'; // Opciones: 'hoy', 'semana', 'mes', 'todos'
    public $fechaInicio = '';
    public $fechaFin = '';

    public function render()
    {
        $query = ReporteGenerado::with(['orden', 'user', 'plantillaReporte']);

        // Aplicar filtro de búsqueda
        if (strlen($this->searchTerm) >= 2) {
            $query->where(function($q) {
                $q->where('nombre_archivo_generado', 'like', '%' . $this->searchTerm . '%')
                  ->orWhereHas('orden', fn($sq) => $sq->where('id', 'like', '%' . $this->searchTerm . '%'))
                  ->orWhereHas('user', fn($sq) => $sq->where('name', 'like', '%' . $this->searchTerm . '%'))
                  ->orWhereHas('plantillaReporte', fn($sq) => $sq->where('nombre_descriptivo', 'like', '%' . $this->searchTerm . '%'));
            });
        }
        
        // Aplicar filtros de fecha
        switch ($this->filtroFecha) {
            case 'hoy':
                $query->whereDate('created_at', today());
                break;
            case 'semana':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'mes':
                $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                break;
            case 'rango':
                if ($this->fechaInicio && $this->fechaFin) {
                    $query->whereBetween('created_at', [$this->fechaInicio, $this->fechaFin]);
                }
                break;
        }

        $reportes = $query->latest()->paginate(15);

        return view('livewire.reportes-table', [
            'reportes' => $reportes
        ]);
    }
}
