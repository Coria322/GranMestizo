@extends('layouts.app')
@section('content')

<form class="login" method="POST" action="{{ route('password.update') }}">
    @csrf
    <div class="login-panel">
        <img class="logo-mex" alt="Logo restaurante" src="{{ asset('imgs/Logo Mex.png') }}">
        <b class="titulo">Crea una nueva contraseña</b>

        <input type="hidden" name="token" value="{{ $token }}">

        {{-- Contraseña --}}
        <input type="password" name="password" id="password"
            placeholder="Nueva contraseña" class="campo" required style="margin-top: 2%;">

        {{-- Confirmación --}}
        <input type="password" name="password_confirmation" id="passwordconfirmation"
            placeholder="Confirmar contraseña" class="campo" required>

        {{-- Botón mágico para ambos --}}
        <button type="button" onclick="togglePasswords()"
            style="margin-bottom:2%; background: none; border: none; color: #3182ce; cursor: pointer;">
            Mostrar / Ocultar contraseñas
        </button>

        <button type="submit" class="iniciar-btn">Cambiar contraseña</button>
        <a href="{{ route('login') }}" class="olvidaste">Volver al inicio de sesión</a>
    </div>
</form>

<script>
    function togglePasswords() {
        let campos = ['password', 'passwordconfirmation'];

        campos.forEach(id => {
            let input = document.getElementById(id);
            if (input) {
                input.type = (input.type === 'password') ? 'text' : 'password';
            }
        });
    }
</script>

@endsection