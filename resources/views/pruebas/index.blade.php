<h2>Lista de Usuarios</h2>

<a href="{{ route('pruebas.create') }}">➕ Crear nuevo usuario</a>
        @if ($errors->any())
        <div style="color: red; margin-bottom: 1rem;">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>RFC</th>
            <th>Acciones</th>
            <th>Cambiar Rol</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->USUARIO_ID }}</td>
                <td>{{ $usuario->USUARIO_NOMBRE }} {{ $usuario->USUARIO_APELLIDO }}</td>
                <td>{{ $usuario->USUARIO_CORREO }}</td>
                <td>{{ $usuario->USUARIO_ROL }}</td>
                <td>{{ $usuario->cliente->CLIENTE_RFC ?? $usuario->empleado->EMPLEADO_RFC ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('pruebas.show', $usuario->USUARIO_ID) }}">👁️ Ver</a> |
                    <a href="{{ route('pruebas.edit', $usuario->USUARIO_ID) }}">✏️ Editar</a>
                </td>
                <td>
                    <form action="{{ route('pruebas.cambiarRol', $usuario->USUARIO_ID) }}" method="POST" style="display:inline;">
                        @csrf
                        <select name="nuevo_rol" required>
                            <option value="" disabled selected>Selecciona rol</option>
                            <option value="CLIENTE" {{ $usuario->USUARIO_ROL == 'CLIENTE' ? 'selected' : '' }}>Cliente</option>
                            <option value="EMPLEADO" {{ $usuario->USUARIO_ROL == 'EMPLEADO' ? 'selected' : '' }}>Empleado</option>
                            <option value="ADMINISTRADOR" {{ $usuario->USUARIO_ROL == 'ADMINISTRADOR' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        <button type="submit">🔄</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No hay usuarios registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>
