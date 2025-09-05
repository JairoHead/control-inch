<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

// --- Controladores ---
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DescargoController;
use App\Http\Controllers\FotoOrdenController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTAS PÚBLICAS ---
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

Route::get('/mostrar-foto/orden/{filename}', function ($filename) {
    $path = 'uploads/ordenes_fotos/' . $filename;
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return response()->file(storage_path('app/public/' . $path));
})->name('orden.mostrar_foto');

Route::get('/mostrar-foto/perfil/{filename}', function ($filename) {
    $path = 'uploads/profile-photos/' . $filename;
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return response()->file(storage_path('app/public/' . $path));
})->name('perfil.mostrar_foto');

// --- GRUPO DE RUTAS QUE REQUIEREN AUTENTICACIÓN ---
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
         return redirect()->route('ordenes.index');
    })->name('dashboard');

    // --- RUTAS DE USUARIO NORMAL ---
    Route::resource('clientes', ClienteController::class);
    Route::resource('inspectores', InspectorController::class)->parameters(['inspectores' => 'inspector']);
    Route::get('/ordenes/crear', [OrdenController::class, 'create'])->name('ordenes.create');
    Route::post('/ordenes', [OrdenController::class, 'store'])->name('ordenes.store');
    Route::prefix('ordenes/{orden}/editar')->name('ordenes.edit.')->group(function () {
        Route::get('/antes', [OrdenController::class, 'editFaseAntes'])->name('antes');
        Route::get('/durante', [OrdenController::class, 'editFaseDurante'])->name('durante');
        Route::get('/despues', [OrdenController::class, 'editFaseDespues'])->name('despues');
    });

    Route::resource('ordenes', OrdenController::class)->except(['create', 'store', 'edit'])->parameters(['ordenes' => 'orden']);

    
    Route::delete('/fotos-orden/{foto}', [FotoOrdenController::class, 'destroy'])->name('fotos_orden.destroy');
    Route::delete('/reportes/{reporte}', [ReporteController::class, 'destroy'])->name('reportes.destroy');

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/orden/{orden}/generar', [ReporteController::class, 'generarReporte'])->name('reportes.generar');

    // --- RUTAS TIPO API (INTERNAS) ---
    Route::get('/api/ubicacion/provincias/{departamento_id}', [LocationController::class, 'getProvincias'])->name('api.ubicacion.provincias');
    Route::get('/api/ubicacion/distritos/{provincia_id}', [LocationController::class, 'getDistritos'])->name('api.ubicacion.distritos');
    Route::get('/api/descargos/parte1/{tipoId}', [DescargoController::class, 'getParte1Options'])->name('api.descargos.parte1');
    Route::get('/api/descargos/parte2/{tipoId}', [DescargoController::class, 'getParte2Options'])->name('api.descargos.parte2');
    Route::get('/api/descargos/parte3/{tipoId}', [DescargoController::class, 'getParte3Options'])->name('api.descargos.parte3');
    Route::get('/api/plantillas/{tipoTrabajo}', [ReporteController::class, 'getPlantillasPorTipo'])->name('api.plantillas.por_tipo');


    // =======================================================================
    // ========= INICIO: GRUPO DE RUTAS DE ADMINISTRACIÓN ====================
    // =======================================================================
    // Este grupo completo solo será accesible para usuarios con el rol 'admin'
    Route::middleware('is.admin')
         ->prefix('admin')
         ->name('admin.')
         ->group(function() {
        
        // Ruta para la gestión de usuarios (CRUD completo)
        Route::resource('users', UserController::class);
        
    });
    // =====================================================================
    // =========== FIN: GRUPO DE RUTAS DE ADMINISTRACIÓN ===================
    // =====================================================================

}); // Fin del grupo middleware 'auth'

// --- INCLUIR RUTAS DE AUTENTICACIÓN ---
require __DIR__.'/auth.php';