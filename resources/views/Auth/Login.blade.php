@extends('layouts.app')
@section('content')
<form class="login" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="login-panel">
        <img class="logo-mex" alt="Logo restaurante" src="{{ asset('imgs/Logo Mex.png') }}">
        <b class="titulo">El Gran Mestizo</b>

        {{-- Campo correo --}}
        <input type="email" class="campo" name="correo" placeholder="Correo" value="{{ old('correo') }}" id="correo">
        @error('correo')
        <div class="err_field">{{ $message }}</div>
        @enderror

        {{-- Campo contraseña --}}
        <input type="password" class="campo" name="contraseña" placeholder="Contraseña" id="login_password">
        @error('contraseña')
        <div class="err_field">{{ $message }}</div>
        @enderror

        {{-- Botón mostrar/ocultar --}}
        <button type="button" onclick="togglePasswordLogin()"
                style="margin-bottom: 2%; background: none; border: none; color: #3182ce; cursor: pointer;">
            Mostrar / Ocultar contraseña
        </button>

        <button type="submit" class="iniciar-btn">Iniciar Sesión</button>
        <a href="{{ route('password.request') }}" class="olvidaste">¿Olvidaste la contraseña?</a>
        <a href="{{ route('registro.create') }}" class="nCuenta">¿Aún no tienes cuenta?<span>REGÍSTRATE AQUÍ</span></a>    
    </div>
</form>

<script>
    function togglePasswordLogin() {
        const input = document.getElementById("login_password");
        if (input) {
            input.type = input.type === "password" ? "text" : "password";
        }
    }
</script>
@endsection
