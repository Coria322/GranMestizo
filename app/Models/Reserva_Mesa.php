<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva_Mesa extends Model
{
    protected $table = 'reserva_mesa';

    // Si no necesitas un ID único, puedes omitir la clave primaria y usar una clave compuesta lógica
    protected $primaryKey = 'ID'; // Opcional: solo si realmente lo tienes como campo único

    public $timestamps = true; // Si tienes created_at y updated_at

    protected $fillable = [
        'RESERVA_ID', 
        'MESA_ID', 
        'STATUS'
    ];

    // Relación con la tabla 'reservas'
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'RESERVA_ID', 'RESERVA_ID');
    }

    // Relación con la tabla 'mesas'
    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'MESA_ID', 'MESA_ID');
    }
}
