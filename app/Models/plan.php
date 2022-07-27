<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plan extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table ='plans';
    protected $fillable = [
        'codigo',
        'nombre',
        'oportunidad_plan',
        'semestre_ejecucion',
        'duracion',
        'estado',
        'avance',
        'evaluacion_eficacia',

    ];


    public function users(){
        return $this->belongsTo(User::class,'id_user');
    }
    public function estandars(){
        return $this->belongsTo(Estandar::class,'id_estandar');
    }
    public function fuentes(){
        return $this->hasMany(Fuentes::class,'id');
    }
    public function metas(){
        return $this->hasMany(Metas::class,'id');
    }
    public function recursos(){
        return $this->hasMany(Recursos::class,'id');
    }
    public function observaciones(){
        return $this->hasMany(Observaciones::class,'id');
    }
    public function problemasOportunidade(){
        return $this->hasMany(ProblemasOportunidades::class,'id');
    }
    public function accionesMejoras(){
        return $this->hasMany(AccionesMejoras::class,'id');
    }
    public function causasRaices(){
        return $this->hasMany(causasRaices::class,'id');
    } 
    public function responsablesplanesmejora(){
        return $this->hasMany(ResponsablesPlanesMejora::class,'id');
    }
    //
  

}
