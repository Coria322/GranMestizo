<div>

    <h1 style="color:rebeccapurple;">ADMIN</h1>
    <h1>ya estas logeado</h1>
    <h2>Bienvenido {{ Auth::guard('Usuario')->user()->USUARIO_NOMBRE }}</h2>
    <h2>Tu APELLIDO es {{ Auth::guard('Usuario')->user()->USUARIO_APELLIDO }}</h2>
    <h2>Tu correo es {{ Auth::guard('Usuario')->user()->USUARIO_CORREO }}</h2>
    <h2>Tu contraseña es {{ Auth::guard('Usuario')->user()->USUARIO_PWD }}</h2>
    <h2>Tu rol es {{ Auth::guard('Usuario')->user()->USUARIO_ROL }}</h2>
    <h2>Tu id es {{ Auth::guard('Usuario')->user()->USUARIO_ID }}</h2>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Cerrar sesión</button>
        
    </div>