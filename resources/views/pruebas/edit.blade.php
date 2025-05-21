<div class="container">
    <h2>Editar Usuario</h2>

    <form action="{{ route('pruebas.update', $usuario->USUARIO_ID) }}" method="POST">
        @csrf
        @method('PUT')
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
            <input type="text" name="USUARIO_NOMBRE" value="{{ $usuario->USUARIO_NOMBRE }}" required>
        </div>

        <div>
            <label>Apellido:</label>
            <input type="text" name="USUARIO_APELLIDO" value="{{ $usuario->USUARIO_APELLIDO }}" required>
        </div>

        <div>
            <label>Correo:</label>
            <input type="email" name="USUARIO_CORREO" value="{{ $usuario->USUARIO_CORREO }}" required>
        </div>

        @if($usuario->USUARIO_ROL === 'CLIENTE')
        <div>
            <label>RFC Cliente:</label>
            <input type="text" name="CLIENTE_RFC" value="{{ old('CLIENTE_RFC', $usuario->cliente->CLIENTE_RFC ?? '') }}">
        </div>
        @elseif($usuario->USUARIO_ROL === 'EMPLEADO')
        <div>
            <label>RFC Empleado:</label>
            <input type="text" name="EMPLEADO_RFC" value="{{ old('EMPLEADO_RFC', $usuario->empleado->EMPLEADO_RFC ?? '') }}">
        </div>
        <div>
            <label>Turno:</label>
            <input type="text" name="EMPLEADO_TURNO" value="{{ old('EMPLEADO_TURNO', $usuario->empleado->EMPLEADO_TURNO ?? '') }}">
        </div>
        <div>
            <label>Status:</label>
            <input type="text" name="EMPLEADO_STATUS" value="{{ old('EMPLEADO_STATUS', $usuario->empleado->EMPLEADO_STATUS ?? '') }}">
        </div>
        @elseif($usuario->USUARIO_ROL === 'ADMINISTRADOR')
        <div>

        </div>
        <!-- Agrega más campos específicos para administrador -->
        @endif

        <button type="submit">Actualizar</button>
    </form>
</div>