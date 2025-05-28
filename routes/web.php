<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\empleadoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\mesaController;

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
Route::prefix('admin')->middleware('check:ADMINISTRADOR')->group(function () {    
    Route::get('/', [adminController::class, 'home'])->name('admin.main');
   // Rutas de gestión de usuarios
    Route::get('/usuarios/{id}', [UsuarioController::class,'show'])->name('usuarios.detalle');
    Route::get('/usuarios/{id}/edit', [UsuarioController::class,'edit'])->name('usuario.edit');
    Route::post('/usuarios/cambiar-rol/{id}', [UsuarioController::class,'cambiarRol'])->name('admin.cambiarRol');
    Route::patch('/usuarios/{id}/patch', [UsuarioController::class,'update'])->name('usuario.update');
    Route::put('/usuarios/{id}/rol', [UsuarioController::class, 'cambiarRol'])->name('admin.cambiarRol');    
    Route::delete('/usuarios/eliminar/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    //Rutas de gestión de mesas
    Route::get('/mesas/crear', [MesaController::class,'create'])->name('mesas.create');
    Route::get('/mesas/{id}', [MesaController::class,'show'])->name('mesas.show');
    Route::post('/mesas/store', [MesaController::class,'store'])->name('mesas.store');
    Route::get('/mesas/{id}/edit', [MesaController::class, 'edit'])->name('mesas.edit');
    Route::put('/mesas/{id}/edit', [MesaController::class, 'update'])->name('mesas.update');
    Route::delete('/mesas/eliminar/{id}', [MesaController::class, 'destroy'])->name('mesas.destroy');
});