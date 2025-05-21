<h2>Detalle del Usuario</h2>
        @if ($errors->any())
        <div style="color: red; margin-bottom: 1rem;">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
<p><strong>ID:</strong> {{ $usuario->USUARIO_ID }}</p>
<p><strong>Nombre:</strong> {{ $usuario->USUARIO_NOMBRE }}</p>
<p><strong>Apellido:</strong> {{ $usuario->USUARIO_APELLIDO }}</p>
<p><strong>Correo:</strong> {{ $usuario->USUARIO_CORREO }}</p>
<p><strong>Rol:</strong> {{ $usuario->USUARIO_ROL }}</p>
<p><strong>RFC:</strong> {{ $usuario->cliente->CLIENTE_RFC ?? $usuario->empleado->EMPLEADO_RFC ?? 'N/A' }}</p>

<a href="{{ route('pruebas.edit', $usuario->USUARIO_ID) }}">Editar</a>
