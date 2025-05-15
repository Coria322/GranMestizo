
<div>
    <h1 style="color:rebeccapurple;">ADMIN</h1>
    <h1>ya estas logeado</h1>
    <h2>Bienvenido {{ $usuario->USUARIO_NOMBRE }}</h2>
    <h2>Tu APELLIDO es {{ $usuario->USUARIO_APELLIDO }}</h2>
    <h2>Tu correo es {{ $usuario->USUARIO_CORREO }}</h2>
    <h2>Tu contraseña es {{ $usuario->USUARIO_PWD }}</h2>
    <h2>Tu rol es {{ $usuario->USUARIO_ROL }}</h2>
    <h2>Tu id es {{ $usuario->USUARIO_ID }}</h2>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Cerrar sesión</button>
        
</div>