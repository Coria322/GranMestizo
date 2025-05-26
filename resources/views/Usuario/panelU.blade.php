@extends('layouts.app')
@section('htclass','bod')
@section('bodyclass', 'bod')
@section('content')
@vite('resources/css/cliente/panelP.css')

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
    </nav>

    {{-- SECCIÓN INICIO --}}
    @if ($seccionActiva === 'inicio')
    <div class="seccion-inicio">
        <!-- MENSAJE DE BIENVENIDA -->
        <div class="rectangle-4">
            <span class="experiencia-gastronomica">
                ¿LISTO PARA DISFRUTAR DE UNA EXPERIENCIA GASTRONÓMICA INOLVIDABLE?<br />
                AQUÍ PUEDES REVISAR TUS RESERVACIONES ACTIVAS, VER DETALLES ANTERIORES
                Y GESTIONAR TU PERFIL. ¡TE ESPERAMOS CON GUSTO EN TU PRÓXIMA VISITA!
            </span>
        </div>

        <!-- BOTONES DE ACCIÓN RÁPIDA -->
        <div class="acciones-rapidas">
            <a href="{{ route('reservas.create') }}">
                <div class="rectangle-5">
                    <span class="nueva-reservacion">NUEVA RESERVACIÓN</span>
                </div>
            </a>
            
            <a href="mailto:soporte@granmestizo.com">
                <div class="rectangle-6">
                    <span class="soporte">SOPORTE</span>
                </div>
            </a>
        </div>
    </div>
    @endif

    {{-- SECCIÓN PERFIL --}}
    @if ($seccionActiva === 'perfil')
    <div class="seccion-perfil">
        <div class="tarjeta-perfil">
            <div class="header-perfil">
                <h2>MI PERFIL</h2>
            </div>
            <div class="contenido-perfil">
                <div class="info-usuario">
                    <div class="campo-perfil">
                        <label>Nombre:</label>
                        <span>{{ $usuarioGlobal->USUARIO_NOMBRE }}</span>
                    </div>
                    <div class="campo-perfil">
                        <label>Apellido:</label>
                        <span>{{ $usuarioGlobal->USUARIO_APELLIDO }}</span>
                    </div>
                    <div class="campo-perfil">
                        <label>Correo:</label>
                        <span>{{ $usuarioGlobal->USUARIO_CORREO }}</span>
                    </div>
                    <div class="campo-perfil">
                        <label>Fecha de Nacimiento:</label>
                        <span>{{ $usuarioGlobal->USUARIO_FECHANAC ?? 'No especificada' }}</span>
                    </div>
                </div>
                <div class="acciones-perfil">
                    <button class="btn-editar-usuario" onclick="editarPerfil()">
                        EDITAR PERFIL
                    </button>
                    <button class="btn-cambiar-pass" onclick="cambiarPassword()">
                        CAMBIAR CONTRASEÑA
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- SECCIÓN RESERVACIONES --}}
    @if ($seccionActiva === 'reservaciones')
    <div class="seccion-reservaciones-cliente">
        <div class="tarjeta-reservaciones">
            <div class="header-reservaciones">
                <h2>MIS RESERVACIONES</h2>
            </div>
            
            @if($reservasCliente && $reservasCliente->count() > 0)
            <div class="lista-reservaciones">
                @foreach($reservasCliente as $reserva)
                <div class="item-reservacion">
                    <div class="info-reservacion">
                        <div class="fecha-reserva">
                            <strong>{{ \Carbon\Carbon::parse($reserva->RESERVA_FECHA)->format('d/m/Y') }}</strong>
                        </div>
                        <div class="hora-reserva">
                            {{ $reserva->RESERVA_HORA }}
                        </div>
                        <div class="detalles-reserva">
                            <span>{{ $reserva->RESERVA_COMENSALES }} comensales</span>
                            <span>Mesa: {{ $reserva->reservasMesas->first()?->MESA_ID ?? 'Por asignar' }}</span>
                        </div>
                    </div>
                    <div class="estado-reserva">
                        <span class="badge-estado {{ strtolower($reserva->reservasMesas->first()?->STATUS ?? 'pendiente') }}">
                            {{ $reserva->reservasMesas->first()?->STATUS ?? 'Pendiente' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- Paginación --}}
            @if($reservasCliente->hasPages())
            <div class="paginacion-cliente">
                {{ $reservasCliente->appends(['seccion' => 'reservaciones'])->links() }}
            </div>
            @endif
            @else
            <div class="sin-reservaciones">
                <p>No tienes reservaciones registradas.</p>
                <a href="{{ route('reservas.create') }}" class="btn-nueva-reserva">
                    HACER MI PRIMERA RESERVACIÓN
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- BOTÓN CERRAR SESIÓN CONSTANTE -->
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
<script src="{{ asset('js/cliente/navigation.js') }}"></script>

<script>
// Funciones para perfil
function editarPerfil() {
    alert('Función de editar perfil pendiente de implementar');
}

function cambiarPassword() {
    alert('Función de cambiar contraseña pendiente de implementar');
}
</script>
@endsection