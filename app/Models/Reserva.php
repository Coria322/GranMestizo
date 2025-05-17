<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'RESERVA_ID',
        'CLIENTE_ID',
        'EMPLEADO_ID',
        'RESERVA_COMENSALES', 
        'RESERVA_FECHA', 
        'RESERVA_HORA',
    ];

    public $timestamps = true;

    protected $primaryKey = 'RESERVA_ID';

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

    public function cliente(){
        return $this->belongsTo(Cliente::class,'CLIENTE_ID', 'USUARIO_ID');
    }

    public function empleado(){
        return $this->belongsTo(Empleado::class,'EMPLEADO_ID', 'USUARIO_ID');
    }
}
