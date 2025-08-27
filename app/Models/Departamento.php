<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Departamento extends Model {
    use HasFactory;
    protected $table = 'ubigeo_departamentos';
    public $timestamps = false;
    protected $fillable = ['departamento', 'ubigeo'];
    public function provincias() { return $this->hasMany(Provincia::class, 'departamento_id'); }

    protected $appends = ['nombre'];
    public function getNombreAttribute() { // <--- AÑADIR (si no está)
        return $this->departamento;
    }
}