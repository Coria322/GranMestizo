@extends('layouts.app')
@section('content')
<form class="login" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="login-panel">
        <img class="logo-mex" alt="Logo restaurante" src="{{ asset('imgs/Logo Mex.png') }}">
        <b class="titulo">El Gran Mestizo</b>

        <input type="email" class="campo" name="correo" placeholder="Correo" value="{{ old('correo') }}" id="correo">
        @error('correo')
        <div class="err_field">{{ $message }}</div>
        @enderror

        <input type="password" class="campo" name="contraseña" placeholder="Contraseña">
        @error('contraseña')
        <div class="err_field">{{ $message }}</div>
        @enderror

        <button type="submit" class="iniciar-btn">Iniciar Sesión</button>
        <a href="#" class="olvidaste">¿Olvidaste la contraseña?</a>
    </div>
</form>
@endsection
