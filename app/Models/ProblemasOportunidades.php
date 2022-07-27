<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemasOportunidades extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table ='problemas_oportunidades';
    protected $fillable = [
        'descripcion',

    ];
    public function plans(){
        return $this->belongsTo(plan::class,'id_plan');
    }
}
