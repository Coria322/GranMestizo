
<div class="container">
    <h2>Cambiar Rol de Usuario</h2>

            @if ($errors->any())
        <div style="color: red; margin-bottom: 1rem;">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
    <form action="{{ route('pruebas.cambiarRol', $usuario->USUARIO_ID) }}" method="POST">
        @csrf

        <p><strong>Nombre:</strong> {{ $usuario->USUARIO_NOMBRE }} {{ $usuario->USUARIO_APELLIDO }}</p>
        <p><strong>Correo:</strong> {{ $usuario->USUARIO_CORREO }}</p>
        <p><strong>Rol actual:</strong> {{ $usuario->USUARIO_ROL }}</p>

        <div>
            <label>Nuevo Rol:</label>
            <select name="nuevo_rol" required>
                <option value="">--Selecciona--</option>
                <option value="CLIENTE">Cliente</option>
                <option value="EMPLEADO">Empleado</option>
                <option value="ADMINISTRADOR">Administrador</option>
            </select>
        </div>

        <button type="submit">Cambiar Rol</button>
    </form>
</div>

