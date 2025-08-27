<?php

namespace App\Http\Controllers;

use App\Models\DescargoParte1;
use App\Models\DescargoParte2;
use App\Models\DescargoParte3;
use Illuminate\Http\Request;

class DescargoController extends Controller
{
    public function getParte1Options($tipoId)
    {
        // Usamos el modelo para buscar en la BD y devolvemos como JSON
        return response()->json(DescargoParte1::where('descargo_tipo_id', $tipoId)->orderBy('id')->get());
    }

    public function getParte2Options($tipoId)
    {
        return response()->json(DescargoParte2::where('descargo_tipo_id', $tipoId)->orderBy('id')->get());
    }

    public function getParte3Options($tipoId)
    {
        return response()->json(DescargoParte3::where('descargo_tipo_id', $tipoId)->orderBy('id')->get());
    }
}