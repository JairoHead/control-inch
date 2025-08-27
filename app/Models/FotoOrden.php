<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
            get: fn () => $this->path ? route('orden.mostrar_foto', ['filename' => basename($this->path)]) : null,
        );
    }
}