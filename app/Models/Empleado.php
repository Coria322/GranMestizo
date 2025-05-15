<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados'; // Nombre de la tabla

    // La clave primaria en este caso es 'USUARIO_ID'
    protected $primaryKey = 'USUARIO_ID';

    public $timestamps = false;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'EMPLEADO_RFC',
        'EMPLEADO_TURNO', 
        'EMPLEADO_STATUS',
    ];

    // La relación con el modelo 'Usuario'
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'USUARIO_ID', 'USUARIO_ID');
    }
}
