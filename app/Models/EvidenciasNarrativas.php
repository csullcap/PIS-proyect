<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciasNarrativas extends Model
{
    use HasFactory;
    protected $table = 'evidencias_narrativas';
    protected $fillable = [
        'codigo',
        'denominacion',
        'adjunto',
    ];

    public function narrativas()
    {
        return $this->belongsTo(Narrativa::class, 'id_narrativa');
    }
}
