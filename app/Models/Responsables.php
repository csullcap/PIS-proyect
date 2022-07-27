<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsables extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table ='responsables';
    protected $fillable = [
        'nombre',

    ];
    public function responsablesplanesmejora(){
        return $this->hasmany(ResponsablesPlanesMejora::class,'id');
    }
    
}
