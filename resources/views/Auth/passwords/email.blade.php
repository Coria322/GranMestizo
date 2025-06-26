{{-- //TODO MOSTRAR ERRORES --}}
@extends('layouts.app')
@section('content')
<form class="login" method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="login-panel">
        <img class="logo-mex" alt="Logo restaurante" src="{{ asset('imgs/Logo Mex.png') }}" style="margin-bottom: 20px;">
        
        <b class="titulo" style="display: block; margin-bottom: 25px;">Recupera tu cuenta</b>

        <input type="email" class="campo" name="email" placeholder="Correo registrado"
               value="{{ old('email') }}" required style="margin-bottom: 30px;">
        @error('email')
            <div class="err_field" style="margin-bottom: 15px;">{{ $message }}</div>
        @enderror

        @if(session('status'))
            <div class="msg_success" style="margin-bottom: 15px;">{{ session('status') }}</div>
        @endif

        <button type="submit" class="iniciar-btn" style="margin-bottom: 20px;">Enviar enlace</button>

        <a href="{{ route('login') }}" class="olvidaste" style="display: block; margin-top: 10px;">Volver al inicio de sesión</a>
    </div>
</form>
@endsection
