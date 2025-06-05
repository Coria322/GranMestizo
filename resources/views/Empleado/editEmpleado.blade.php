@extends('layouts.app')
@section('htclass','bod')
@section('bodyclass', 'bod')
@section('content')
@vite('resources/css/edit.css')

<div class="container mt-5">
    <h2 class="mb-4">Editar Mi Perfil - Empleado</h2>

    {{-- Mostrar mensajes de éxito --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Formulario para actualizar datos del empleado --}}
    <form action="{{ route('empleado.actualizar') }}" method="post" class="mb-4">
        @csrf
        @method('patch')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" 
                   class="form-control @error('USUARIO_NOMBRE') is-invalid @enderror" 
                   name="USUARIO_NOMBRE" 
                   value="{{ old('USUARIO_NOMBRE', $usuarioGlobal->USUARIO_NOMBRE) }}" 
                   required
                   placeholder="Ingresa tu nombre">
            @error('USUARIO_NOMBRE')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Apellido:</label>
            <input type="text" 
                   class="form-control @error('USUARIO_APELLIDO') is-invalid @enderror" 
                   name="USUARIO_APELLIDO" 
                   value="{{ old('USUARIO_APELLIDO', $usuarioGlobal->USUARIO_APELLIDO) }}" 
                   required
                   placeholder="Ingresa tu apellido">
            @error('USUARIO_APELLIDO')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico:</label>
            <input type="email" 
                   class="form-control @error('USUARIO_CORREO') is-invalid @enderror" 
                   name="USUARIO_CORREO" 
                   value="{{ old('USUARIO_CORREO', $usuarioGlobal->USUARIO_CORREO) }}" 
                   required
                   placeholder="ejemplo@correo.com">
            @error('USUARIO_CORREO')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">RFC:</label>
            <input type="text" 
                   class="form-control @error('EMPLEADO_RFC') is-invalid @enderror" 
                   name="EMPLEADO_RFC" 
                   value="{{ old('EMPLEADO_RFC', $usuarioGlobal->empleado->EMPLEADO_RFC ?? '') }}" 
                   maxlength="13"
                   pattern="[A-Z]{4}[0-9]{6}[A-Z0-9]{3}"
                   placeholder="XAXX010101000"
                   style="text-transform: uppercase;">
            @error('EMPLEADO_RFC')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Formato: 4 letras + 6 números + 3 caracteres alfanuméricos</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Turno:</label>
            <select class="form-control @error('EMPLEADO_TURNO') is-invalid @enderror" 
                    name="EMPLEADO_TURNO">
                <option value="">Seleccionar turno (opcional)</option>
                <option value="MATUTINO" {{ old('EMPLEADO_TURNO', $usuarioGlobal->empleado->EMPLEADO_TURNO ?? '') == 'MATUTINO' ? 'selected' : '' }}>
                    Matutino
                </option>
                <option value="VESPERTINO" {{ old('EMPLEADO_TURNO', $usuarioGlobal->empleado->EMPLEADO_TURNO ?? '') == 'VESPERTINO' ? 'selected' : '' }}>
                    Vespertino
                </option>
                <option value="NOCTURNO" {{ old('EMPLEADO_TURNO', $usuarioGlobal->empleado->EMPLEADO_TURNO ?? '') == 'NOCTURNO' ? 'selected' : '' }}>
                    Nocturno
                </option>
            </select>
            @error('EMPLEADO_TURNO')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Estado:</label>
            <input type="text" 
                   class="form-control" 
                   value="{{ $usuarioGlobal->empleado->EMPLEADO_STATUS ?? 'N/A' }}" 
                   readonly
                   disabled>
            <small class="form-text text-muted">El estado solo puede ser modificado por un administrador</small>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
            <a href="{{ route('Empleado.panelP', ['seccion' => 'datos']) }}" class="btn btn-secondary ms-2">Cancelar</a>
        </div>
    </form>
</div>

<!-- Script para RFC en mayúsculas automáticamente -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rfcInput = document.querySelector('input[name="EMPLEADO_RFC"]');
    if (rfcInput) {
        rfcInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    }
});
</script>
@endsection