<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\empleadoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReservaController;
//Rutas publicas

// Rutas para el login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//RUTA DE REGISTRO DE NUEVO USUARIO
Route::get('/registro', function () {
    return view('Registro.registroP');
})->name('registro.create');

Route::post('/registro', [UsuarioController::class, 'store'])->name('registro.store');


//Rutas de error
Route::get('/forbidden', function () {
    return view('errors.403');
})->name('forbidden');

// Rutas de bienvenida
Route::get('/', function () {
    return view('bienvenida');
})->name('bienvenida');


//TODO proteger o definir si se puede reservar sin cuenta
//rutas de reserva
Route::get('/Reservas/reservar', [ReservaController::class, 'create']);
Route::post('/Reservas/reservar', [ReservaController::class, 'store'])->name('crear-reserva');

// Middleware para proteger rutas
// Rutas protegidas

//RUTA DE CLIENTE
Route::prefix('Cliente')->middleware('check:CLIENTE')->group(function () {
    Route::get('/Usuario-panel', [clienteController::class,'panel' ])->name('Usuario.panelU');
});

//Rutas de empleado
Route::prefix('Empleado')->middleware('check:EMPLEADO')->group(function () {
    Route::get('/Empleado-reservaciones', [empleadoController::class, 'panelP'])->name('Empleado.panelP');
});

//Rutas de admin
//Rutas de admin
Route::prefix('admin')->middleware('check:ADMINISTRADOR')->group(function () {
    Route::get('/', [adminController::class, 'home'])->name('admin.main');
    Route::get('/usuarios/{id}', [UsuarioController::class,'show'])->name('usuarios.detalle');
    Route::delete('/usuarios/eliminar/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
});

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


// Route::get('/reservas/ver', [ReservaController::class, 'index'])->name('reservas.index');
Route::get('/reservas/ver/{id_us?}', [ReservaController::class, 'index'])->name('reservas.index');
