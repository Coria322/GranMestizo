<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\Usuario;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:Usuario');
    }
}
