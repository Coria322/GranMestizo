<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reportes';

    protected $primaryKey = 'REPORTE_ID';

    protected $keyType = 'string';

    public $incrementing = false;
    
    protected $fillable = [
        'REPORTE_ID',
        'REPORTE_CONTENIDO',
        'USUARIO_ID',
    ];

    public function usuario(){
       return $this->belongsTo(Usuario::class,'USUARIO_ID','USUARIO_ID');
    }
}
