<?php

use App\Http\Controllers\ReservaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Rutas de la API para gestionar reservas.
 * Estas rutas permiten crear reservas, obtener fechas bloqueadas y horas disponibles.
 */
Route::post('/reservas', [ReservaController::class, 'store']);
Route::get('/fechas-bloqueadas', [ReservaController::class, 'obtenerFechasBloqueadas']);
Route::get('/horas-disponibles', [ReservaController::class, 'obtenerHorasDisponibles']);

