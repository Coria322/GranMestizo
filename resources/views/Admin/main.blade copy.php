<div>
    <h1 style="color:rebeccapurple;">ADMIN</h1>
    <h1>Ya estás logeado</h1>
    <h2>Bienvenido {{ $usuarioGlobal->USUARIO_NOMBRE }}</h2>
    <h2>Tu apellido es {{ $usuarioGlobal->USUARIO_APELLIDO }}</h2>
    <h2>Tu correo es {{ $usuarioGlobal->USUARIO_CORREO }}</h2>
    <h2>Tu contraseña es {{ $usuarioGlobal->USUARIO_PWD }}</h2>
    <h2>Tu rol es {{ $usuarioGlobal->USUARIO_ROL }}</h2>
    <h2>Tu ID es {{ $usuarioGlobal->USUARIO_ID }}</h2>

    <hr>

    <h1>Datos del ADMIN</h1>
    @foreach ($usuarioGlobal->administrador->getAttributes() as $key => $value)
        <h2>{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</h2>
    @endforeach

    <hr>

    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</div>
