<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests; // Para Laravel 9+
// Si usas Laravel 8 o anterior, podrías necesitar también:
// use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests; // Para Laravel 9+
    // Si usas Laravel 8 o anterior, podría ser:
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}