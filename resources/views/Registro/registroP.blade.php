@extends('layouts.app')
@section('content')
@vite('resources/css/registro/registro.css')

<div class="main-container">
    <div class="con-p">
        <span class="crea-tu-cuenta">CREA TU CUENTA AQUÍ</span>
        
        <form class="etiq-campos" method="POST" action="{{ route('registro.store') }}">
            @csrf
            
            <!-- Campo Nombre -->
            <label class="nombre-s" for="USUARIO_NOMBRE">Nombre(s)</label>
            <input type="text" 
                   class="campo-input campo-nombre @error('USUARIO_NOMBRE') error @enderror" 
                   name="USUARIO_NOMBRE" 
                   id="USUARIO_NOMBRE"
                   value="{{ old('USUARIO_NOMBRE') }}" 
                   placeholder="Ingresa tu nombre"
                   required>
            @error('USUARIO_NOMBRE')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Campo Apellidos -->
            <label class="apellidos" for="USUARIO_APELLIDO">Apellidos</label>
            <input type="text" 
                   class="campo-input campo-apellido @error('USUARIO_APELLIDO') error @enderror" 
                   name="USUARIO_APELLIDO" 
                   id="USUARIO_APELLIDO"
                   value="{{ old('USUARIO_APELLIDO') }}" 
                   placeholder="Ingresa tus apellidos"
                   required>
            @error('USUARIO_APELLIDO')
            <div class="error-message">{{ $message }}</div>
            @enderror
            
            <!-- Campo Email -->
            <label class="email-field" for="USUARIO_CORREO">Correo electrónico</label>
            <input type="email" 
                   class="campo-input email-input @error('USUARIO_CORREO') error @enderror" 
                   name="USUARIO_CORREO" 
                   id="USUARIO_CORREO"
                   value="{{ old('USUARIO_CORREO') }}" 
                   placeholder="ejemplo@correo.com"
                   required>
            @error('USUARIO_CORREO')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Campo Contraseña -->
            <label class="password-field" for="USUARIO_PWD">Contraseña</label>
            <input type="password" 
                   class="campo-input password-input @error('USUARIO_PWD') error @enderror" 
                   name="USUARIO_PWD" 
                   id="USUARIO_PWD"
                   placeholder="Mínimo 8 caracteres, mayúsculas, números y símbolos"
                   required>
            @error('USUARIO_PWD')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Campo Confirmar Contraseña -->
            <label class="password-confirm-field" for="USUARIO_PWD_confirmation">Confirmar contraseña</label>
            <input type="password" 
                   class="campo-input password-confirm-input @error('USUARIO_PWD_confirmation') error @enderror" 
                   name="USUARIO_PWD_confirmation" 
                   id="USUARIO_PWD_confirmation"
                   placeholder="Repite tu contraseña"
                   required>
            @error('USUARIO_PWD_confirmation')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Botón Continuar -->
            <div class="continue-button">
                <button type="submit" class="continuar-button">
                    CONTINUAR
                </button>
            </div>

            <!-- Enlace a Login -->
            <div class="login-link">
                <span>¿Ya tienes una cuenta? </span>
                <a href="{{ route('login') }}">INICIA SESIÓN AQUÍ</a>
            </div>
        </form>
    </div>
    
    <!-- Branding lateral -->
    <div class="branding-section">
        <span class="el-gran-mestizo">El Gran Mestizo</span>
        <div class="logo-mex"></div>
    </div>
</div>

<!-- Validación JavaScript en tiempo real -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación de RFC en tiempo real
    const rfcInput = document.getElementById('CLIENTE_RFC');
    if (rfcInput) {
        rfcInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    }

    // Validación de contraseñas coincidentes
    const password = document.getElementById('USUARIO_PWD');
    const confirmPassword = document.getElementById('USUARIO_PWD_confirmation');
    
    function validatePasswords() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Las contraseñas no coinciden');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    if (password && confirmPassword) {
        password.addEventListener('input', validatePasswords);
        confirmPassword.addEventListener('input', validatePasswords);
    }
});
</script>
@endsection