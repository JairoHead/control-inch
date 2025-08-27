<?php
 
 namespace App\Models;
 
 use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Database\Eloquent\Model;
 
 class ReporteGenerado extends Model
 {
     use HasFactory;
 
     protected $fillable = [
         'orden_id',
         'user_id',
         'plantilla_reporte_id',
         'nombre_archivo_generado',
     ];
 
     public function orden() { return $this->belongsTo(Orden::class); }
     public function user() { return $this->belongsTo(User::class); }
     public function plantillaReporte() { return $this->belongsTo(PlantillaReporte::class); }
 }
