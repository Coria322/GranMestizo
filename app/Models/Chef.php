<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chef extends Model
{
    protected $table = 'chefs';


    
    protected $fillable = [
        'CHEF_NOMBRE',
        'CHEF_DESCRIPCION',
        'CHEF_IMAGEN',
    ];

    public $timestamps = false;
}
