<div>
    <h1 style="color:rebeccapurple;">EMPLEADO</h1>
    <h1>Datos generales</h1>
    <h2>Bienvenido {{ $usuario->USUARIO_NOMBRE }}</h2>
    <h2>Tu apellido es {{ $usuario->USUARIO_APELLIDO }}</h2>
    <h2>Tu correo es {{ $usuario->USUARIO_CORREO }}</h2>
    <h2>Tu contraseña es {{ $usuario->USUARIO_PWD }}</h2>
    <h2>Tu rol es {{ $usuario->USUARIO_ROL }}</h2>
    <h2>Tu ID es {{ $usuario->USUARIO_ID }}</h2>

    <hr>

    <h1>Datos del {{ $usuario->USUARIO_ROL }}</h1>
    @foreach ($usuario->empleado->getAttributes() as $key => $value)
        <h2>{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</h2>
    @endforeach

    <hr>

    <h1>Reservas asignadas</h1>
    @forelse ($usuario->empleado->reservas as $reserva)
        <div style="margin-bottom: 1rem;">
            <h3>Reserva ID: {{ $reserva->RESERVA_ID }}</h3>
            <h4>Fecha: {{ $reserva->RESERVA_FECHA }} | Hora: {{ $reserva->RESERVA_HORA }}</h4>
            <h4>Comensales: {{ $reserva->RESERVA_COMENSALES }}</h4>
            <h4>Cliente: {{ $reserva->cliente->usuario->USUARIO_NOMBRE ?? 'Sin cliente' }}</h4>
            <h4>Mesas asignadas:</h4>
            <ul>
                @foreach ($reserva->mesas as $mesa)
                    <li>ID: {{ $mesa->MESA_ID }} | Sección: {{ $mesa->MESA_SECCION }} | Capacidad: {{ $mesa->MESA_CAPACIDAD }}</li>
                @endforeach
            </ul>
        </div>
    @empty
        <h3>No tienes reservas asignadas.</h3>
    @endforelse

    <hr>

    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</div>
