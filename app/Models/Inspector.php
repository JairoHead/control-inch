<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- Importar

class Inspector extends Model
{
    use HasFactory, SoftDeletes; // <-- Usar

    protected $table = 'inspectores'; // Nombre de tu tabla

    /**
     * The attributes that are mass assignable.
     * AJUSTA ESTOS CAMPOS SEGÚN TU TABLA 'inspectores'
     */
    protected $fillable = [
        'dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'nro_celular',
        // ¿Algún otro campo como 'codigo_inspector', 'email', 'telefono'? Añádelo aquí.
    ];

    /**
     * Indica si el modelo debe gestionar timestamps (created_at, updated_at).
     * Ponlo en 'false' si NO existen en tu tabla.
     * Recuerda que SoftDeletes necesita 'deleted_at'.
     */
    public $timestamps = false; // <-- Ajusta si tienes created/updated_at

    /**
     * Los atributos que deben ser casteados.
     * SoftDeletes maneja 'deleted_at' automáticamente.
     *
     * @var array
     */
    protected $casts = [
        // 'deleted_at' => 'datetime',
    ];

    // --- Opcional: Accesor para Nombre Completo (útil) ---
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}");
    }

    // --- Relación con Órdenes ---
    public function ordenes()
    {
        // Asume clave foránea 'inspector_id' en tabla 'ordenes'
        return $this->hasMany(Orden::class);
    }
}