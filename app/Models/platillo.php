<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Platillo extends Model
{
    use HasFactory;

    protected $table = 'platillos';
    protected $primaryKey = 'PLATILLO_ID';

    protected $fillable = [
        'PLATILLO_NOMBRE',
        'PLATILLO_DESCRIPCION',
        'PLATILLO_IMAGEN',
        'PLATILLO_STATUS', // Agregado para manejar el estado del platillo
    ];
}
