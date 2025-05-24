<div class="container">
    <h2>Crear Usuario</h2>

    <form action="{{ route('pruebas.store') }}" method="POST">
        @csrf

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
            <input type="text" name="USUARIO_NOMBRE" value="{{ old('USUARIO_NOMBRE') }}" required>
        </div>

        <div>
            <label>Apellido:</label>
            <input type="text" name="USUARIO_APELLIDO" value="{{ old('USUARIO_APELLIDO') }}" required>
        </div>

        <div>
            <label>Correo:</label>
            <input type="email" name="USUARIO_CORREO" value="{{ old('USUARIO_CORREO') }}" required>
        </div>

        <div>
            <label>Contraseña:</label>
            <input type="password" name="USUARIO_PWD" required>
        </div>

        <div>
            <label>Confirmar Contraseña:</label>
            <input type="password" name="USUARIO_PWD_confirmation" required>
        </div>

        <div>
            <label>Rol:</label>
            <select name="USUARIO_ROL">
                <option value="CLIENTE">Cliente</option>
                <option value="EMPLEADO">Empleado</option>
                <option value="ADMINISTRADOR">Administrador</option>
            </select>
        </div>

        <div>
            <label>RFC (solo para clientes):</label>
            <input type="text" name="CLIENTE_RFC">
        </div>

        <button type="submit">Crear</button>
    </form>
</div>