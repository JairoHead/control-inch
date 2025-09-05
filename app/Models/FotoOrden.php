<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class FotoOrden extends Model
{
    use HasFactory;

    protected $fillable = ['orden_id', 'path', 'caption'];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    // Accesor para obtener la URL de esta foto
   protected function url(): Attribute
{
    return Attribute::make(
        get: function () { // Usamos una función anónima completa para mayor claridad
            if ($this->path) {
                // Asumiendo que $this->path guarda la ruta relativa al disco 'public',
                // por ejemplo: 'uploads/ordenes_fotos/nombre_de_la_orden.jpg'
                return Storage::url($this->path);
            }
            return null; // O una imagen por defecto si no hay path
        }
    );
}
}