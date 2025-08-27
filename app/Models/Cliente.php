<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- Importar SoftDeletes

class Cliente extends Model
{
    use HasFactory, SoftDeletes; // <-- Usar SoftDeletes

    protected $table = 'clientes';

    protected $fillable = [
        'dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'nro_celular',
    ];

    /**
     * Indica que el modelo NO debe gestionar created_at/updated_at.
     * PERO SoftDeletes SÍ necesita 'deleted_at'. Asegúrate que exista en la tabla.
     */
    public $timestamps = false; // <-- Mantenlo si NO tienes created/updated_at

    /**
     * Los atributos que deben ser casteados.
     * SoftDeletes automáticamente castea 'deleted_at'.
     *
     * @var array
     */
    protected $casts = [
        // 'deleted_at' => 'datetime', // SoftDeletes lo maneja
    ];

    // Accessor para nombre completo (ya lo tenías, está bien)
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}");
    }

    // Relación con Órdenes (ya la tenías, está bien)
    public function ordenes()
    {
        return $this->hasMany(Orden::class);
    }
}