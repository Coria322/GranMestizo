<div class="container">
    <h2>Editar Usuario</h2>

    {{-- Formulario para actualizar datos generales --}}
    <form action="{{ route('usuario.update', $usuario->USUARIO_ID) }}" method="post">
        @csrf
        @method('patch')

        @if ($errors->any())
            <div style="color: red; margin-bottom: 1rem;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label>Nombre:</label>
            <input type="text" name="USUARIO_NOMBRE" value="{{ old('USUARIO_NOMBRE', $usuario->USUARIO_NOMBRE) }}" required>
        </div>

        <div>
            <label>Apellido:</label>
            <input type="text" name="USUARIO_APELLIDO" value="{{ old('USUARIO_APELLIDO', $usuario->USUARIO_APELLIDO) }}" required>
        </div>

        <div>
            <label>Correo:</label>
            <input type="email" name="USUARIO_CORREO" value="{{ old('USUARIO_CORREO', $usuario->USUARIO_CORREO) }}" required>
        </div>

        {{-- Incluimos el rol como campo oculto si no es admin, para no perderlo --}}
        @if($usuarioGlobal->USUARIO_ROL !== 'ADMINISTRADOR')
            <input type="hidden" name="USUARIO_ROL" value="{{ $usuario->USUARIO_ROL }}">
        @endif

        {{-- Campos por tipo de rol --}}
        @if($usuario->USUARIO_ROL === 'CLIENTE')
        <div>
            <label>RFC Cliente:</label>
            <input type="text" name="CLIENTE_RFC" value="{{ old('CLIENTE_RFC', $usuario->cliente->CLIENTE_RFC ?? '') }}">
        </div>
        @elseif($usuario->USUARIO_ROL === 'EMPLEADO')
        <div>
            <label>RFC Empleado:</label>
            <input type="text" name="EMPLEADO_RFC" value="{{ old('EMPLEADO_RFC', $usuario->empleado->EMPLEADO_RFC ?? $usuario->cliente->CLIENTE_RFC) }}">
        </div>

        <div>
            <label>Turno:</label>
            <input type="text" name="EMPLEADO_TURNO" value="{{ old('EMPLEADO_TURNO', $usuario->empleado->EMPLEADO_TURNO ?? '') }}">
        </div>

        <div>
            <label>Status:</label>
            <select name="EMPLEADO_STATUS">
                <option value="ACTIVO" {{ old('EMPLEADO_STATUS', $usuario->empleado->EMPLEADO_STATUS ?? '') == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                <option value="INACTIVO" {{ old('EMPLEADO_STATUS', $usuario->empleado->EMPLEADO_STATUS ?? '') == 'INACTIVO' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        @elseif($usuario->USUARIO_ROL === 'ADMINISTRADOR')
        <div>
            <p>No hay campos adicionales para administradores.</p>
        </div>
        @endif

        <button type="submit">Actualizar</button>
    </form>
    <a href="{{ route('login') }}">Volver</a>

    {{-- Si el usuario global es admin, permitir cambiar el rol --}}
    @if($usuarioGlobal->USUARIO_ROL === 'ADMINISTRADOR')
      {{-- Segundo formulario: cambiar rol --}}
<form action="{{ route('admin.cambiarRol', $usuario->USUARIO_ID) }}" method="POST">
    @csrf
    @method('put')
    <div>
        <label>Nuevo Rol:</label>
        <select name="nuevo_rol" id="nuevo_rol" required>
            <option value="CLIENTE" {{ old('nuevo_rol', $usuario->USUARIO_ROL) === 'CLIENTE' ? 'selected' : '' }}>Cliente</option>
            <option value="EMPLEADO" {{ old('nuevo_rol', $usuario->USUARIO_ROL) === 'EMPLEADO' ? 'selected' : '' }}>Empleado</option>
            <option value="ADMINISTRADOR" {{ old('nuevo_rol', $usuario->USUARIO_ROL) === 'ADMINISTRADOR' ? 'selected' : '' }}>Administrador</option>
        </select>
    </div>

    <div id="clienteFields" style="display: none;">
        <label>RFC Cliente:</label>
        <input type="text" name="CLIENTE_RFC" id="CLIENTE_RFC"
            value="{{ old('CLIENTE_RFC', $usuario->cliente->CLIENTE_RFC ?? '') }}">
    </div>

    <div id="empleadoFields" style="display: none;">
        <label>RFC Empleado:</label>
        <input type="text" name="EMPLEADO_RFC" id="EMPLEADO_RFC"
            value="{{ old('EMPLEADO_RFC', $usuario->empleado->EMPLEADO_RFC ?? '') }}">

        <label>Turno:</label>
        <input type="text" name="EMPLEADO_TURNO" value="{{ old('EMPLEADO_TURNO', $usuario->empleado->EMPLEADO_TURNO ?? 'M') }}">

        <label>Status:</label>
        <select name="EMPLEADO_STATUS">
            <option value="ACTIVO" {{ old('EMPLEADO_STATUS', $usuario->empleado->EMPLEADO_STATUS ?? '') == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
            <option value="INACTIVO" {{ old('EMPLEADO_STATUS', $usuario->empleado->EMPLEADO_STATUS ?? '') == 'INACTIVO' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <button type="submit">Cambiar Rol</button>
</form>

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
