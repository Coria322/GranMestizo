<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'RESERVA_ID',
        'RESERVA_COMENSALES', 
        'RESERVA_FECHA', 
        'RESERVA_HORA'
    ];

    // Relación con la tabla intermedia 'reserva_mesa'
    public function reservasMesas()
    {
        return $this->hasMany(Reserva_Mesa::class, 'RESERVA_ID');
    }

    // Método para obtener las mesas asociadas a esta reserva
    public function mesas()
    {
        return $this->belongsToMany(Mesa::class, 'reserva_mesa', 'RESERVA_ID', 'MESA_ID')
                    ->withPivot('STATUS')
                    ->withTimestamps();
    }
}
