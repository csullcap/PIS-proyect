<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuentes extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $table ='fuentes';
    protected $fillable = [
        'descripcion',
        
    ];
    public function plans(){
        return $this->belongsTo(plan::class,'id_plan');
    }
}
