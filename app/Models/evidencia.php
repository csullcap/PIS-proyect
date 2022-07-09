<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evidencia extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table ='evidencias';
    protected $fillable = [
        'codigo',
        'denominacion',
        'adjunto',

    ];


    public function users(){
        return $this->belongsTo(User::class,'id_user');
    }
    public function estandars(){
        return $this->belongsTo(Estandar::class,'id_estandar');
    }

}
