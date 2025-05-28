<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Editar Usuario</h2>

    {{-- Formulario para actualizar datos generales --}}
    <form action="{{ route('usuario.update', $usuario->USUARIO_ID) }}" method="post" class="mb-4">
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
            <input type="text" class="form-control" name="USUARIO_NOMBRE" value="{{ old('USUARIO_NOMBRE', $usuario->USUARIO_NOMBRE) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Apellido:</label>
            <input type="text" class="form-control" name="USUARIO_APELLIDO" value="{{ old('USUARIO_APELLIDO', $usuario->USUARIO_APELLIDO) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo:</label>
            <input type="email" class="form-control" name="USUARIO_CORREO" value="{{ old('USUARIO_CORREO', $usuario->USUARIO_CORREO) }}" required>
        </div>

        @if($usuarioGlobal->USUARIO_ROL !== 'ADMINISTRADOR')
            <input type="hidden" name="USUARIO_ROL" value="{{ $usuario->USUARIO_ROL }}">
        @endif

        @if($usuario->USUARIO_ROL === 'CLIENTE')
        <div class="mb-3">
            <label class="form-label">RFC Cliente:</label>
            <input type="text" class="form-control" name="CLIENTE_RFC" value="{{ old('CLIENTE_RFC', $usuario->cliente->CLIENTE_RFC ?? $usuario->empleado->EMPLEADO_RFC) }}">
        </div>
        @elseif($usuario->USUARIO_ROL === 'EMPLEADO')
        <div class="mb-3">
            <label class="form-label">RFC Empleado:</label>
            <input type="text" class="form-control" name="EMPLEADO_RFC" value="{{ old('EMPLEADO_RFC', $usuario->empleado->EMPLEADO_RFC ?? $usuario->cliente->CLIENTE_RFC) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Turno:</label>
            <input type="text" class="form-control" name="EMPLEADO_TURNO" value="{{ old('EMPLEADO_TURNO', $usuario->empleado->EMPLEADO_TURNO ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Status:</label>
            <select class="form-select" name="EMPLEADO_STATUS">
                <option value="LIBRE" {{ old('EMPLEADO_STATUS', $usuario->empleado->EMPLEADO_STATUS ?? '') == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                <option value="OCUPADO" {{ old('EMPLEADO_STATUS', $usuario->empleado->EMPLEADO_STATUS ?? '') == 'INACTIVO' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        @elseif($usuario->USUARIO_ROL === 'ADMINISTRADOR')
        <div class="mb-3">
            <p class="form-text">No hay campos adicionales para administradores.</p>
        </div>
        @endif

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('login') }}" class="btn btn-secondary ms-2">Volver</a>
    </form>

    @if($usuarioGlobal->USUARIO_ROL === 'ADMINISTRADOR')
    {{-- Segundo formulario: cambiar rol --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Cambiar Rol</h5>
            <form action="{{ route('admin.cambiarRol', $usuario->USUARIO_ID) }}" method="POST">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label class="form-label">Nuevo Rol:</label>
                    <select class="form-select" name="nuevo_rol" id="nuevo_rol" required>
                        <option value="CLIENTE" {{ old('nuevo_rol', $usuario->USUARIO_ROL) === 'CLIENTE' ? 'selected' : '' }}>Cliente</option>
                        <option value="EMPLEADO" {{ old('nuevo_rol', $usuario->USUARIO_ROL) === 'EMPLEADO' ? 'selected' : '' }}>Empleado</option>
                        <option value="ADMINISTRADOR" {{ old('nuevo_rol', $usuario->USUARIO_ROL) === 'ADMINISTRADOR' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>

                <div id="clienteFields" class="mb-3" style="display: none;">
                    <label class="form-label">RFC Cliente:</label>
                    <input type="text" class="form-control" name="CLIENTE_RFC" id="CLIENTE_RFC"
                        value="{{ old('CLIENTE_RFC', $usuario->cliente->CLIENTE_RFC ?? '') }}">
                </div>

                <div id="empleadoFields" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label">RFC Empleado:</label>
                        <input type="text" class="form-control" name="EMPLEADO_RFC" id="EMPLEADO_RFC"
                            value="{{ old('EMPLEADO_RFC', $usuario->empleado->EMPLEADO_RFC ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Turno:</label>
                        <input type="text" class="form-control" name="EMPLEADO_TURNO" value="{{ old('EMPLEADO_TURNO', $usuario->empleado->EMPLEADO_TURNO ?? 'M') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status:</label>
                        <select class="form-select" name="EMPLEADO_STATUS">
                            <option value="LIBRE" {{ old('EMPLEADO_STATUS', $usuario->empleado->EMPLEADO_STATUS ?? '') == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                            <option value="OCUPADO" {{ old('EMPLEADO_STATUS', $usuario->empleado->EMPLEADO_STATUS ?? '') == 'INACTIVO' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning">Cambiar Rol</button>
            </form>
        </div>
    </div>

    <script>
        const selectRol = document.getElementById('nuevo_rol');
        const clienteFields = document.getElementById('clienteFields');
        const empleadoFields = document.getElementById('empleadoFields');
        const clienteRFC = document.getElementById('CLIENTE_RFC');
        const empleadoRFC = document.getElementById('EMPLEADO_RFC');

        function toggleRoleFields() {
            const rol = selectRol.value;

            clienteFields.style.display = rol === 'CLIENTE' ? 'block' : 'none';
            empleadoFields.style.display = rol === 'EMPLEADO' ? 'block' : 'none';

            // Si pasa de CLIENTE a EMPLEADO y el RFC del cliente existe, usarlo como base
            if (rol === 'EMPLEADO' && clienteRFC && empleadoRFC && clienteRFC.value && !empleadoRFC.value) {
                empleadoRFC.value = clienteRFC.value;
            }
        }

        selectRol.addEventListener('change', toggleRoleFields);
        window.addEventListener('DOMContentLoaded', toggleRoleFields);
    </script>
    @endif
</div>
<!-- Bootstrap JS CDN (optional, for some components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
