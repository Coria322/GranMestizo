@extends('layouts.app')
@section('htclass','bod')
@section('bodyclass', 'bod')
@section('content')
@section('header')
@include('partials.nav')
@endsection
<div class="contenedor">

    <div class="bienvenida-admin">
        <p class="bienvenida-texto">Bienvenido administrador</p>
    </div>

    {{-- Botones de navegación --}}
    <div class="botones-admin" id="botones-principales">
        <a href="{{ route('admin.main', ['seccion' => 'usuarios']) }}">
            <button class="boton-admin {{ $seccionActiva === 'usuarios' ? 'activo' : '' }}">Usuarios</button>
        </a>
        <a href="{{ route('admin.main', ['seccion' => 'mesas']) }}">
            <button class="boton-admin {{ $seccionActiva === 'mesas' ? 'activo' : '' }}">Mesas</button>
        </a>
        <a href="{{ route('admin.main', ['seccion' => 'empleados']) }}">
            <button class="boton-admin {{ $seccionActiva === 'empleados' ? 'activo' : '' }}">Empleados</button>
        </a>

        <a href="{{ route('admin.main', ['seccion' => 'reservas'])}}">
            <button class="boton-admin" {{ $seccionActiva === 'reservas' ? 'activo' : '' }}>Reservas</button>
        </a>

        <a href="{{ route('admin.main', ['seccion' => 'perfil'])}}">
            <button class="boton-admin" {{ $seccionActiva === 'perfil' ? 'activo' : '' }}>Perfil</button>
        </a>
    </div>

    {{-- Sección Usuarios --}}
    @if ($seccionActiva === 'usuarios')
    <div id="section-usuarios" class="section">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->USUARIO_ID }}</td>
                    <td>{{ $usuario->USUARIO_NOMBRE }}</td>
                    <td>{{ $usuario->USUARIO_APELLIDO }}</td>
                    <td>{{ $usuario->USUARIO_CORREO }}</td>
                    <td>{{ $usuario->USUARIO_ROL }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">No hay Usuarios registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="paginacion">
            {{ $usuarios->appends(['seccion' => 'usuarios'])->links() }}
        </div>

        <div class="acciones-adm">
            <a href=""><button class="boton-admin bon">Ver usuario</button></a>
            <a href=""><button class="boton-admin bon">Eliminar Usuario</button></a>
            <a href=""><button class="boton-admin bon">Modificar usuario</button></a>
        </div>
    </div>
    @endif

    {{-- Sección Mesas --}}
    @if ($seccionActiva === 'mesas')
    <div id="section-mesas" class="section">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Capacidad</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mesas as $mesa)
                <tr>
                    <td>{{ $mesa->MESA_ID }}</td>
                    <td>{{ $mesa->MESA_CAPACIDAD }}</td>
                    <td>{{ $mesa->MESA_STATUS }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">No hay reservas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="paginacion">
            {{ $mesas->appends(['seccion' => 'mesas'])->links() }}
        </div>
        <div class="acciones-adm">
            <a href=""><button class="boton-admin bon">Crear mesa</button></a>
            <a href=""><button class="boton-admin bon">Eliminar mesa</button></a>
            <a href=""><button class="boton-admin bon">Modificar mesa</button></a>
        </div>
    </div>
    @endif

    {{-- Sección Empleados --}}
    @if ($seccionActiva === 'empleados')
    <div id="section-empleados" class="section">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($empleados as $empleado)
                <tr>
                    <td>{{ $empleado->USUARIO_ID }}</td>
                    <td>{{ $empleado->usuario->USUARIO_NOMBRE }}</td>
                    <td>{{ $empleado->usuario->USUARIO_APELLIDO }}</td>
                    <td>{{ $empleado->EMPLEADO_RFC }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">No hay empleados registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="paginacion">
            {{ $empleados->appends(['seccion' => 'empleados'])->links() }}
        </div>
        <div class="acciones-adm">
            <a href=""><button class="boton-admin bon">Ver Empleado</button></a>
            <a href=""><button class="boton-admin bon">Eliminar Empleado</button></a>
            <a href=""><button class="boton-admin bon">Modificar Empleado</button></a>
        </div>
    </div>
    @endif

    @if ($seccionActiva === 'reservas')
    <div id='section-reservas' class="section">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Cliente</th>
                    <th>Empleado</th>
                    <th>Comensales</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservas as $reserva)
                <tr>
                    <td>{{$reserva->RESERVA_ID}}</td>
                    <td>{{$reserva->CLIENTE_ID}}</td>
                    <td>{{$reserva->EMPLEADO_ID}}</td>
                    <td>{{$reserva->RESERVA_COMENSALES}}</td>
                    <td>{{$reserva->RESERVA_FECHA}}</td>
                    <td>{{$reserva->RESERVA_HORA}}</td>
                    <td>{{$reserva->reservasMesas->first()?->STATUS}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">No hay reservas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="paginacion">
            {{ $reservas->links() }}
        </div>
        <div class="acciones-adm">
            <a href=""><button class="boton-admin bon">Ver Reserva</button></a>
            <a href=""><button class="boton-admin bon">Eliminar Reserva</button></a>
            <a href=""><button class="boton-admin bon">Modificar Reserva</button></a>
        </div>
    </div>
    @endif

    @if ($seccionActiva === 'perfil')
    <div class="section-perfil">
        <table class="tabla-perfil">
            @foreach ($usuarioGlobal->getAttributes() as $key => $value )
            @if (!in_array($key, ['USUARIO_PWD']))
            @php
            $partes = explode('_', $key);
            $label = isset($partes[1])
            ? ucfirst(strtolower($partes[1]))
            : ucfirst(strtolower($partes[0]));
            @endphp
            <tr>
                <th>{{ $label }}</th>
                <td>{{ $value }}</td>
            </tr>
            @endif
            @endforeach
        </table>
    </div>
    @endif
    <!-- boton constante de logout -->
    <div class="cont-const">

        <form action="{{ route('logout') }}" method="post" style="display: flex; justify-content: flex-end; margin-top: 1rem;">
            @csrf
            <button class="boton-admin" id="logout">
                Cerrar sesión
            </button>
        </form>
    </div>
</div>
@endsection