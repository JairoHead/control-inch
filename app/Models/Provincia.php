<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;
    protected $table = 'ubigeo_provincias';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['provincia', 'ubigeo', 'departamento_id'];

    protected $appends = ['nombre'];
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function distritos()
    {
        return $this->hasMany(Distrito::class, 'provincia_id');
    }

    // ========================================================
    // INICIO: ACCESOR AÑADIDO
    // ========================================================
    /**
     * Obtiene el nombre de la provincia para ser accedido como $provincia->nombre.
     *
     * @return string
     */
    public function getNombreAttribute()
    {
        return $this->provincia; // Retorna el valor de la columna 'provincia'
    }
    // ========================================================
    // FIN: ACCESOR AÑADIDO
    // ========================================================
}