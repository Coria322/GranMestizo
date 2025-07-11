<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes'; // Nombre de la tabla

    protected $primaryKey = 'USUARIO_ID';

    public $timestamps = false;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'CLIENTE_RFC',
    ];

    // La relación con el modelo 'Usuario'
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'USUARIO_ID', 'USUARIO_ID');
    }

    public function reservas(){
        return $this->hasMany(Reserva::class,'CLIENTE_ID', 'USUARIO_ID');
    }
}
