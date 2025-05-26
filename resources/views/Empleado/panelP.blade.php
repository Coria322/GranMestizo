@extends('layouts.app')
@section('htclass','bod')
@section('bodyclass', 'bod')
@section('content')
@vite('resources/css/empleado/panelP.css')

<div class="main-container">
    <div class="empleado-panel">
        <div class="frame">
            <!-- HEADER DE BIENVENIDA -->
            <div class="general">
                <div class="rectangle"></div>
                <div class="group">
                    <h1 class="bienvenido-empleado">¡BIENVENIDO! {{ $usuarioGlobal->USUARIO_NOMBRE }}</h1>
                </div>
            </div>

            <!-- BOTONES DE NAVEGACIÓN PRINCIPAL -->
            <nav class="btns-p">
                <div class="btns-p-1">
                    <a href="{{ route('Empleado.panelP', ['seccion' => 'reservaciones']) }}">
                        <button class="btn-reservacion {{ $seccionActiva === 'reservaciones' ? 'activo' : '' }}" data-section="reservaciones">
                            <div class="rectangle-2"></div>
                            <span class="reservaciones">RESERVACIONES</span>
                        </button>
                    </a>
                    <a href="{{ route('Empleado.panelP', ['seccion' => 'datos']) }}">
                        <button class="btn-datos-p {{ $seccionActiva === 'datos' ? 'activo' : '' }}" data-section="datos">
                            <div class="rectangle-3"></div>
                            <span class="datos-personales">DATOS PERSONALES</span>
                        </button>
                    </a>
                    <a href="{{ route('Empleado.panelP', ['seccion' => 'reportes']) }}">
                        <button class="btn-reportes {{ $seccionActiva === 'reportes' ? 'activo' : '' }}" data-section="reportes">
                            <div class="rectangle-4"></div>
                            <span class="reportes">REPORTES</span>
                        </button>
                    </a>
                </div>
            </nav>

            {{-- SECCIÓN RESERVACIONES --}}
            @if ($seccionActiva === 'reservaciones')
            <div class="seccion-reservaciones">
                <!-- TABLA DE RESERVACIONES -->
                <main class="tabla-general">
                    <div class="etiquetas">
                        <div class="rectangle-5"></div>
                        <span class="id">ID</span>
                        <span class="nombre">NOMBRE</span>
                        <span class="fecha">FECHA</span>
                        <span class="hora">HORA</span>
                        <span class="mesa">MESA</span>
                        <span class="cantidad-comensales">CANTIDAD DE COMENSALES</span>
                    </div>
                    <div class="lineas">
                        @forelse ($reservas as $reserva)
                        <div class="fila-reserva" data-reserva-id="{{ $reserva->RESERVA_ID }}">
                            <span class="dato-id">{{ $reserva->RESERVA_ID }}</span>
                            <span class="dato-nombre">{{ $reserva->cliente->USUARIO_NOMBRE ?? 'N/A' }}</span>
                            <span class="dato-fecha">{{ $reserva->RESERVA_FECHA }}</span>
                            <span class="dato-hora">{{ $reserva->RESERVA_HORA }}</span>
                            <span class="dato-mesa">{{ $reserva->reservasMesas->first()?->MESA_ID ?? 'N/A' }}</span>
                            <span class="dato-comensales">{{ $reserva->RESERVA_COMENSALES }}</span>
                        </div>
                        @empty
                        <div class="sin-datos">
                            <span>No hay reservaciones registradas</span>
                        </div>
                        @endforelse
                    </div>
                    
                    {{-- Paginación --}}
                    @if(isset($reservas) && $reservas->hasPages())
                    <div class="paginacion-empleado">
                        {{ $reservas->appends(['seccion' => 'reservaciones'])->links() }}
                    </div>
                    @endif
                </main>

                <!-- BOTONES DE ACCIÓN -->
                <footer class="btns-sec">
                    <div class="btns-sec-6">
                        <button class="btn-editar" id="editarReservacion">
                            <div class="rectangle-7"></div>
                            <span class="editar-reservacion">EDITAR RESERVACIÓN</span>
                        </button>
                        <button class="btn-eliminar" id="eliminarReservacion">
                            <div class="rectangle-8"></div>
                            <span class="eliminar-reservacion">ELIMINAR RESERVACIÓN</span>
                        </button>
                    </div>
                </footer>
            </div>
            @endif

            {{-- SECCIÓN DATOS PERSONALES --}}
            @if ($seccionActiva === 'datos')
            <div class="seccion-datos">
                <div class="tabla-p">
                    <div class="panel-tabla">
                        <div class="cont-etiq">
                            <div class="etiquetas-perfil">
                                <div class="etiqueta-campo">ID</div>
                                <div class="etiqueta-campo">NOMBRE</div>
                                <div class="etiqueta-campo">APELLIDOS</div>
                                <div class="etiqueta-campo">CORREO ELECTRÓNICO</div>
                                <div class="etiqueta-campo">RFC</div>
                            </div>
                        </div>
                        <div class="lineas-tabla">
                            <div class="campo-valor">{{ $empleado->USUARIO_ID }}</div>
                            <div class="campo-valor">{{ $empleado->usuario->USUARIO_NOMBRE }}</div>
                            <div class="campo-valor">{{ $empleado->usuario->USUARIO_APELLIDO }}</div>
                            <div class="campo-valor">{{ $usuarioGlobal->USUARIO_CORREO }}</div>
                            <div class="campo-valor">{{ $empleado->EMPLEADO_RFC }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="btns-datos">
                    <button class="btn-editar-perfil" onclick="editarPerfil()">
                        <div class="rectangle-perfil"></div>
                        <span class="texto-btn-perfil">EDITAR PERFIL</span>
                    </button>
                    <button class="btn-cambiar-pass" onclick="cambiarPassword()">
                        <div class="rectangle-perfil"></div>
                        <span class="texto-btn-perfil">CAMBIAR CONTRASEÑA</span>
                    </button>
                </div>
            </div>
            @endif

            {{-- SECCIÓN REPORTES --}}
            @if ($seccionActiva === 'reportes')
            <div class="seccion-reportes">
                <!-- TABLA DE REPORTES -->
                <main class="tabla-reportes">
                    <div class="etiquetas-reportes">
                        <div class="rectangle-reportes"></div>
                        <span class="titulo-reporte">ESCRIBE TU REPORTE AQUÍ</span>
                    </div>
                    <div class="area-reporte">
                        <textarea class="texto-reporte" id="textoReporte" placeholder="Escribe tu reporte aquí..." rows="8"></textarea>
                    </div>
                </main>

                <!-- BOTÓN DE ENVIAR REPORTE -->
                <footer class="btns-reporte">
                    <button class="btn-enviar-reporte" onclick="enviarReporte()">
                        <div class="rectangle-enviar"></div>
                        <span class="texto-enviar">ENVIAR REPORTE</span>
                    </button>
                </footer>
            </div>
            @endif

            <!-- BOTÓN CERRAR SESIÓN CONSTANTE -->
            <div class="logout-section">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-cerrar-s" id="cerrarSesion">
                        <div class="rectangle-9"></div>
                        <span class="cerrar-sesion">CERRAR SESIÓN</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/empleado/navigation.js') }}"></script>
<script src="{{ asset('js/empleado/reservaciones.js') }}"></script>

<script>
// Función para enviar reporte (solo limpia el textarea)
function enviarReporte() {
    const textarea = document.getElementById('textoReporte');
    const texto = textarea.value.trim();
    
    if (texto === '') {
        alert('Por favor, escribe tu reporte antes de enviarlo.');
        return;
    }
    
    // Simular envío exitoso
    alert('¡Reporte enviado correctamente!');
    
    // Limpiar el textarea
    textarea.value = '';
    textarea.focus();
}

// Funciones para datos personales (si las necesitas)
function editarPerfil() {
    alert('Función de editar perfil pendiente de implementar');
}

function cambiarPassword() {
    alert('Función de cambiar contraseña pendiente de implementar');
}
</script>
@endsection