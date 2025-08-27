<?php

namespace App\Http\Controllers;

use App\Models\Provincia; // Solo necesitas Provincia y Distrito
use App\Models\Distrito;

class LocationController extends Controller
{
   
    public function getProvincias($departamento_id)
    {

        $provincias = Provincia::where('departamento_id', $departamento_id)
                               ->orderBy('provincia') 
                               ->get(); // Obtiene la colección completa de modelos Provincia

        return $provincias; // Laravel serializará esto a JSON automáticamente
    }

    public function getDistritos($provincia_id)
    {

        $distritos = Distrito::where('provincia_id', $provincia_id)
                             ->orderBy('distrito')
                             ->get(); // Obtiene la colección completa de modelos Distrito

        return $distritos; // Laravel serializará esto a JSON automáticamente
    }
}