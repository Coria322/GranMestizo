<div>
    <h1 style="color:rebeccapurple;">EMPLEADO</h1>
    <h1>datos generales</h1>
    <h1>Ya estás logeado</h1>
    <h2>Bienvenido {{ $usuario->USUARIO_NOMBRE }}</h2>
    <h2>Tu APELLIDO es {{ $usuario->USUARIO_APELLIDO }}</h2>
    <h2>Tu correo es {{ $usuario->USUARIO_CORREO }}</h2>
    <h2>Tu contraseña es {{ $usuario->USUARIO_PWD }}</h2>
    <h2>Tu rol es {{ $usuario->USUARIO_ROL }}</h2>
    <h2>Tu id es {{ $usuario->USUARIO_ID }}</h2>
    ----------------------------------------------------------
    <h1>datos de {{ $usuario->USUARIO_ROL }}</h1>

    @foreach ($usuario->empleado->getAttributes() as $key => $value)
        <h2>{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</h2>
    @endforeach
    <h2>usuario id fk {{ $usuario->cliente->USUARIO_ID }}</h2>
    <h2> cliente rfc {{ $usuario->cliente->CLIENTE_RFC }}</h2>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</div>
