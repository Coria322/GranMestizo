<?php

use App\Http\Controllers\ReservaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/reservas', [ReservaController::class, 'store']);
Route::get('/fechas-bloqueadas', [ReservaController::class, 'obtenerFechasBloqueadas']);
Route::get('/horas-disponibles', [ReservaController::class, 'obtenerHorasDisponibles']);

