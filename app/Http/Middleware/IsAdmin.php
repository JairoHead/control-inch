<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario está autenticado Y su rol es 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Permite que la petición continúe
            return $next($request);
        }

        // Si no, lo redirige al dashboard con un error
        return redirect()->route('dashboard')->with('error', 'No tienes permiso para acceder a esta sección.');
    }
}