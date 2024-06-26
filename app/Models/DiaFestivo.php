<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaFestivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'color',
        'dia',
        'mes',
        'anyo',
        'recurrente',
    ];

    
}
