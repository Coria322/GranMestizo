<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{

    use HasFactory, Notifiable;
    // Nombre de la tabla
    protected $table = 'usuarios';

    // Clave primaria
    protected $primaryKey = 'USUARIO_ID';

    public $timestamps = false;

    // Tipo de clave primaria (char en este caso)
    protected $keyType = 'string';

    public $incrementing = false;

    // Atributos asignables en masa
    protected $fillable = [
        'USUARIO_ID',
        'USUARIO_NOMBRE',
        'USUARIO_APELLIDO',
        'USUARIO_CORREO',
        'USUARIO_PWD',
        'USUARIO_ROL',
    ];

    protected $hidden = ['USUARIO_PWD'];

    // Boot method para interceptar eventos
    protected static function boot()
    {
        parent::boot();

        // Evento para hashear la contraseña antes de guardar
        static::saving(function ($usuario) {
            if (isset($usuario->USUARIO_PWD) && Hash::needsRehash($usuario->USUARIO_PWD)) {
                $usuario->USUARIO_PWD = Hash::make($usuario->USUARIO_PWD);
            }
        });
    }

    public function getAuthPassword()
    {
        return $this->USUARIO_PWD;
    }

    public function cliente() {
        return $this->hasOne(Cliente::class, 'USUARIO_ID', 'USUARIO_ID');
    }

    public function administrador(){
        return $this->hasOne(Administrador::class, 'USUARIO_ID', 'USUARIO_ID');
    }

    public function empleado(){
        return $this->hasOne(Empleado::class, 'USUARIO_ID', 'USUARIO_ID');
    }

    public function perfil(){
    switch ($this->USUARIO_ROL) {
        case 'ADMINISTRADOR':
            return $this->load('administrador');
        case 'EMPLEADO':
            return $this->load('empleado');
        case 'CLIENTE':
            return $this->load('cliente');
        default:
            return null;  // O un valor predeterminado si el rol no es reconocido
    }
}
public function getAuthIdentifier()
{
    return $this->USUARIO_ID;
}

}
