<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReservaController;
//Rutas publicas

// Rutas para el login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Rutas de error
Route::get('/forbidden', function () {
    return view('errors.403');
})->name('forbidden');

// Rutas de bienvenida
Route::get('/', function () {
    return view('bienvenida');
})->name('bienvenida');
// Middleware para proteger rutas
// Rutas protegidas

Route::get('/Cliente', function () {
    return view('Usuario.main');
})->name('Usuario.main')->middleware('check:CLIENTE');

//Rutas de empleado
Route::get('/Empleado', function () {
    return view('empleado.main');
})->name('Empleado.main')->middleware('check:EMPLEADO');

//Rutas de admin
Route::get('/Admin', function () {
    return view('admin.main');
})->name('Admin.main')->middleware('check:ADMINISTRADOR');



//TODO eliminar estas rutas y aplicar correctamente agrupaciones y middleware para restringir el acceso a recursos
//prueba de rutas
Route::get('pruebas/crear-usuario', [UsuarioController::class, 'create'])->name('pruebas.create');
Route::post('pruebas/crear-usuario', [UsuarioController::class, 'store'])->name('pruebas.store');

Route::get('pruebas/editar/{id}', [UsuarioController::class, 'edit'])->name('pruebas.edit');
Route::put('pruebas/editar/{id}', [UsuarioController::class, 'update'])->name('pruebas.update');

Route::get('pruebas/usuario/{id}', [UsuarioController::class, 'show'])->name('pruebas.show');

Route::post('pruebas/cambiar-rol/{id}', [UsuarioController::class, 'cambiarRol'])->name('pruebas.cambiarRol');

Route::get('pruebas/usuarios', [UsuarioController::class, 'index'])->name('pruebas.index');

// Mostrar formulario para crear reserva
Route::get('/reservas/crear', [ReservaController::class, 'create'])->name('reservas.create');

// Guardar reserva (POST)
Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');

// Endpoint para obtener horas reservadas en una fecha específica (para el calendario)
Route::get('/reservas/disponibilidad', [ReservaController::class, 'disponibilidad'])->name('reservas.disponibilidad');


Route::get('/reservas/calendario', function () {
    return view('pruebas.calendario'); 
});

Route::get('/reservas/fechas-bloqueadas', [ReservaController::class, 'obtenerFechasBloqueadas'])->name('reservas.fechas-bloqueadas');
Route::get('/reservas/horas-disponibles', [ReservaController::class, 'obtenerHorasDisponibles'])->name('reservas.horas-disponibles');
Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
