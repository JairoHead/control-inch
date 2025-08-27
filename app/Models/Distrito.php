<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distrito extends Model {
    use HasFactory;
    
    protected $table = 'ubigeo_distritos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['distrito', 'ubigeo', 'provincia_id', 'departamento_id']; // Añadido departamento_id

    protected $appends = ['nombre'];
    public function provincia() { return $this->belongsTo(Provincia::class, 'provincia_id'); }

    public function getNombreAttribute() { // <--- AÑADIR
        return $this->distrito;
    }
}