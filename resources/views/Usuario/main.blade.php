<div>
    <h1 style="color:rebeccapurple;">CLIENTE</h1>
    <h1>Datos generales</h1>
    <h2>Bienvenido {{ $usuario->USUARIO_NOMBRE }}</h2>
    <h2>Tu apellido es {{ $usuario->USUARIO_APELLIDO }}</h2>
    <h2>Tu correo es {{ $usuario->USUARIO_CORREO }}</h2>
    <h2>Tu contraseña es {{ $usuario->USUARIO_PWD }}</h2>
    <h2>Tu rol es {{ $usuario->USUARIO_ROL }}</h2>
    <h2>Tu ID es {{ $usuario->USUARIO_ID }}</h2>

    <hr>

    <h1>Datos del {{ $usuario->USUARIO_ROL }}</h1>
    <h2>Usuario ID (FK): {{ $usuario->cliente->USUARIO_ID }}</h2>
    <h2>RFC del cliente: {{ $usuario->cliente->CLIENTE_RFC }}</h2>

    <hr>

    <h1>Reservas</h1>
    @forelse ($usuario->cliente->reservas as $reserva)
        <div style="margin-bottom: 1rem;">
            <h3>Reserva ID: {{ $reserva->RESERVA_ID }}</h3>
            <h4>Fecha: {{ $reserva->RESERVA_FECHA }} | Hora: {{ $reserva->RESERVA_HORA }}</h4>
            <h4>Comensales: {{ $reserva->RESERVA_COMENSALES }}</h4>
            <h4>Empleado asignado: {{ $reserva->empleado->usuario->USUARIO_NOMBRE ?? 'Sin asignar' }}</h4>
            <h4>Mesas reservadas:</h4>
            <ul>
                @foreach ($reserva->mesas as $mesa)
                    <li>ID: {{ $mesa->MESA_ID }} | Sección: {{ $mesa->MESA_SECCION }} | Capacidad: {{ $mesa->MESA_CAPACIDAD }}</li>
                @endforeach
            </ul>
        </div>
    @empty
        <h3>No tienes reservas aún.</h3>
    @endforelse

    <hr>

    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</div>
