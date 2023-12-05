<?php

namespace App\Models;

use App\Models\Salarier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pointage extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_salarier',
        'date',
        'presentAbsent',
        'heureSupp',
        'heureMoin',
        'avance',
        'remarque'
    ];

    public function salarier()
    {
        return $this->belongsTo(Salarier::class, 'id_salarier');
    }
}