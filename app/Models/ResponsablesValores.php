<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsablesValores extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table ='responsables_valores';
    protected $fillable = [
        'valor',

    ];
}
