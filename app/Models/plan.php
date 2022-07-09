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
        'name',
        'oportunidad',
        'semestre',
        'duracion',
        'estado',
        'avance',
        'evaluacion',

    ];


    public function users(){
        return $this->belongsTo(User::class,'id_user');
    }
    public function estandars(){
        return $this->belongsTo(Estandar::class,'id_estandar');
    }

}
