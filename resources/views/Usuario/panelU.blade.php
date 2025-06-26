@extends('layouts.app')
@section('htclass','bod')
@section('bodyclass', 'bod')
@section('content')
@vite('resources/css/cliente/panelP.css')
@if(session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif

<div class="main-container">
    <!-- HEADER DE BIENVENIDA -->
    <div class="rectangle">
        <span class="welcome-user">¡BIENVENIDO! {{ $usuarioGlobal->USUARIO_NOMBRE }}</span>
    </div>

    <!-- BOTONES DE NAVEGACIÓN PRINCIPAL -->
    <nav class="navegacion-principal">
        <a href="{{ route('Usuario.panelU', ['seccion' => 'inicio']) }}">
            <div class="rectangle-1 {{ $seccionActiva === 'inicio' ? 'activo' : '' }}">
                <span class="home">INICIO</span>
            </div>
        </a>

        <a href="{{ route('Usuario.panelU', ['seccion' => 'perfil']) }}">
            <div class="rectangle-2 {{ $seccionActiva === 'perfil' ? 'activo' : '' }}">
                <span class="perfil">PERFIL</span>
            </div>
        </a>

        <a href="{{ route('Usuario.panelU', ['seccion' => 'reservaciones']) }}">
            <div class="rectangle-3 {{ $seccionActiva === 'reservaciones' ? 'activo' : '' }}">
                <span class="reservaciones">RESERVACIONES</span>
            </div>
        </a>

        <a href="{{ route('Usuario.panelU', ['seccion' => 'reportes']) }}">
            <div class="rectangle-3 {{ $seccionActiva === 'reportes' ? 'activo' : '' }}">
                <span class="reservaciones">REPORTES</span>
            </div>
        </a>
    </nav>

    {{-- SECCIÓN INICIO --}}
    @includeWhen($seccionActiva === 'inicio', 'partials.usuario.inicio')
    

    {{-- SECCIÓN PERFIL --}}
    @includeWhen($seccionActiva === 'perfil', 'partials.usuario.perfil')


    {{-- SECCIÓN RESERVACIONES --}}
    @includeWhen($seccionActiva === 'reservaciones', 'partials.usuario.reservaciones')

    {{-- SECCIÓN REPORTES --}}
    @includeWhen($seccionActiva === 'reportes', 'partials.usuario.reportes')

   
    <!-- BOTÓN CERRAR SESIÓN CONSTANTE PARA QUE SE VEA DENTRO DE TODAS LAS SESIONES ACTIVAS -->
    <div class="logout-container">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="rectangle-7">
                <span class="cerrar-sesion">CERRAR SESIÓN</span>
            </button>
        </form>
    </div>
</div>

<!-- Scripts -->
<script>
    // Funciones para perfil
    function editarPerfil() {
        // Redirigir a la vista de edición de perfil
        window.location.href = "{{ route('cliente.editar') }}";
    }

    function cambiarPassword() {
        alert('Función de cambiar contraseña pendiente de implementar');
    }
</script>
@endsection