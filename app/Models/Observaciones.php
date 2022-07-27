<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observaciones extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table ='observaciones';
    protected $fillable = [
        'descripcion',

    ];
    public function plans(){
        return $this->belongsTo(plan::class,'id_plan');
    }
}
