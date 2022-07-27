<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recursos extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table ='recursos';
    protected $fillable = [
        'descripcion',

    ];
    public function plans(){
        return $this->belongsTo(plan::class,'id_plan');
    }
}
