<div>
    <h1 style="color:rebeccapurple;">ADMIN</h1>
    <h1>Ya estás logeado</h1>
    <h2>Bienvenido {{ $usuario->USUARIO_NOMBRE }}</h2>
    <h2>Tu apellido es {{ $usuario->USUARIO_APELLIDO }}</h2>
    <h2>Tu correo es {{ $usuario->USUARIO_CORREO }}</h2>
    <h2>Tu contraseña es {{ $usuario->USUARIO_PWD }}</h2>
    <h2>Tu rol es {{ $usuario->USUARIO_ROL }}</h2>
    <h2>Tu ID es {{ $usuario->USUARIO_ID }}</h2>

    <hr>

    <h1>Datos del ADMIN</h1>
    @foreach ($usuario->admin->getAttributes() as $key => $value)
        <h2>{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</h2>
    @endforeach

    <hr>

    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</div>
