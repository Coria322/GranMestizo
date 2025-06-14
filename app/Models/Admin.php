<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins'; // Nombre de la tabla

    // La clave primaria en este caso es 'USUARIO_ID'
    protected $primaryKey = 'USUARIO_ID';

    public $timestamps = false;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'USUARIO_ID'
    ];

    // La relación con el modelo 'Usuario'
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'USUARIO_ID', 'USUARIO_ID');
    }
}
