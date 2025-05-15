<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva_Mesa extends Model
{
    protected $table = 'reserva_mesa';

    protected $primaryKey = 'ID';  // Puede ir o no, ya que es solo una convención

    protected $fillable = [
        'RESERVA_ID', 
        'MESA_ID', 
        'STATUS'
    ];

    // Relación con la tabla 'reservas'
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'RESERVA_ID', 'ID');
    }

    // Relación con la tabla 'mesas'
    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'MESA_ID', 'ID');
    }
}
