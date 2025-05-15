<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mesa extends Model
{
    /** @use HasFactory<\Database\Factories\MesaFactory> */
    use HasFactory;

    protected $table = 'mesas';

    protected $primaryKey = 'MESA_ID';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'MESA_ID',
        'MESA_CAPACIDAD',
        'MESA_STATUS',
        'MESA_SECCIÓN'
    ];

    public function reservasmesas(){
        return $this->hasMany(Reserva_Mesa::class, 'MESA_ID');
    }

    public function reservas()
    {
        return $this->belongsToMany(Reserva::class, 'reserva_mesa', 'MESA_ID', 'RESERVA_ID')
                    ->withPivot('STATUS')
                    ->withTimestamps();
    }


}
