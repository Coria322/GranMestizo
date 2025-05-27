@extends('layouts.app')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/js/accounts/admin.js'])
@endsection
@section('htclass','bod')
@section('bodyclass', 'bod')
@section('content')
@section('header')
@include('partials.nav')
@endsection
<div class="contenedor">
    {{-- Mostrar mensajes de éxito o error --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
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
            <button class="boton-admin {{ $seccionActiva === 'reservas' ? 'activo' : '' }}">Reservas</button>
        </a>

        <a href="{{ route('admin.main', ['seccion' => 'perfil'])}}">
            <button class="boton-admin {{ $seccionActiva === 'perfil' ? 'activo' : '' }}">Perfil</button>
        </a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
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
                <tr class="fila-usuario selectable-row" 
                    data-id="{{ $usuario->USUARIO_ID }}"
                    data-nombre="{{ $usuario->USUARIO_NOMBRE }}"
                    data-apellido="{{ $usuario->USUARIO_APELLIDO }}"
                    data-correo="{{ $usuario->USUARIO_CORREO }}"
                    data-rol="{{ $usuario->USUARIO_ROL }}">
                    <td>{{ $usuario->USUARIO_ID }}</td>
                    <td>{{ $usuario->USUARIO_NOMBRE }}</td>
                    <td>{{ $usuario->USUARIO_APELLIDO }}</td>
                    <td>{{ $usuario->USUARIO_CORREO }}</td>
                    <td>{{ $usuario->USUARIO_ROL }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">No hay Usuarios registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="paginacion">
            {{ $usuarios->appends(['seccion' => 'usuarios'])->links() }}
        </div>

        {{-- Panel de información del usuario seleccionado --}}
        <div id="usuario-seleccionado" class="usuario-info" style="display: none;">
            <h4>Usuario Seleccionado</h4>
            <p><strong>ID:</strong> <span id="info-id"></span></p>
            <p><strong>Nombre:</strong> <span id="info-nombre"></span> <span id="info-apellido"></span></p>
            <p><strong>Correo:</strong> <span id="info-correo"></span></p>
            <p><strong>Rol:</strong> <span id="info-rol"></span></p>
        </div>

        <div class="acciones-adm">
            <button type="button" class="boton-admin bon" id="btn-ver-usuario" disabled>
                Ver usuario
            </button>
            <button type="button" class="boton-admin bon" id="btn-eliminar-usuario" disabled>
                Eliminar Usuario
            </button>
            <button type="button" class="boton-admin bon" id="btn-modificar-usuario" disabled>
                Modificar usuario
            </button>
            <button type="button" class="boton-admin bon" id="btn-limpiar">
                Limpiar Selección
            </button>
        </div>

        {{-- Formulario oculto para eliminar --}}
        <form id="form-eliminar-usuario" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
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
                    <td colspan="3">No hay mesas registradas</td>
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
                    <th>RFC</th>
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
                    <td colspan="4">No hay empleados registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="paginacion">
            {{ $empleados->appends(['seccion' => 'empleados'])->links() }}
        </div>
        <div class="acciones-adm">
            <button type="button" class="boton-admin bon">Ver Empleado</button>
            <button type="button" class="boton-admin bon">Eliminar Empleado</button>
            <button type="button" class="boton-admin bon">Modificar Empleado</button>
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
                    <td colspan="7">No hay reservas registradas</td>
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

<style>
/* Estilos para la selección de filas */
.selectable-row {
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.selectable-row:hover {
    background-color: #f8f9fa;
}

.selectable-row.selected {
    background-color: #e3f2fd;
    border-left: 4px solid #2196f3;
}

.usuario-info {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin: 10px 0;
    border: 1px solid #dee2e6;
}

.usuario-info h4 {
    margin-bottom: 10px;
    color: #495057;
}

.acciones-adm button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
@endsection