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
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif

    @if(session('error'))
    <script>
        alert("{{ session('error') }}")
    </script>
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

    {{-- Sección Usuarios --}}
    @includeWhen($seccionActiva === 'usuarios', 'partials.secciones.usuario')

    {{-- Sección Mesas --}}
    @includeWhen($seccionActiva === 'mesas', 'partials.secciones.mesas', ['mesas' => $mesas])
    
    {{-- Sección Empleados --}}
    @includeWhen($seccionActiva === 'empleados', 'partials.secciones.empleados', ['empleados' => $empleados])

    {{-- Sección Reservas --}}
    @includeWhen($seccionActiva === 'reservas', 'partials.secciones.reservas')

    {{-- Sección Perfil --}}
    @includeWhen($seccionActiva === 'perfil', 'partials.secciones.perfil', ['usuarioGlobal' => $usuarioGlobal])
    

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