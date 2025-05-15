<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

