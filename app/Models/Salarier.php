<?php

namespace App\Models;

use App\Models\Pointage;
use App\Models\Salarier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salarier extends Model
{
    use HasFactory;
    protected $fillable = [
        'sexe',
        'nom',
        'cin',
        'tel',
        'adresse',
        'salaire',
        'dateEntree',
        'active'
    ];

    public function pointages()
    {
        return $this->hasMany(Pointage::class, 'id_salarier');
    }
}