<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsablesPlanesMejora extends Model
{
    use HasFactory;
    protected $table ='responsables_planes_mejoras';
    protected $fillable = [ ];

    public function responsables(){
        return $this->belongsTo(Responsables::class,'id_responsable');
    }
    public function plans(){
        return $this->belongsTo(plan::class,'id_plan');
    }
}
