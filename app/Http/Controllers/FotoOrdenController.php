<?php

namespace App\Http\Controllers;

use App\Models\FotoOrden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoOrdenController extends Controller
{
    public function destroy(FotoOrden $foto)
    {
        // 1. Eliminar el archivo del disco
        if (Storage::disk('public')->exists($foto->path)) {
            Storage::disk('public')->delete($foto->path);
        }

        // 2. Eliminar el registro de la base de datos
        $foto->delete();

        // 3. Redirigir de vuelta con un mensaje de éxito
        return back()->with('success', 'Foto eliminada correctamente.');
    }
}