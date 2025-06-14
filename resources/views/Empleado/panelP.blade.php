@extends('layouts.app')
@section('htclass','bod')
@section('bodyclass', 'bod')
@section('content')
@vite('resources/css/empleado/panelP.css')
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
                            <span class="dato-nombre">
                                @if($reserva->cliente)
                                {{ $reserva->cliente->USUARIO_NOMBRE ?? '' }} {{ $reserva->cliente->USUARIO_APELLIDO ?? '' }}
                                @else
                                Sin cliente asignado
                                @endif
                            </span>
                            <span class="dato-fecha">{{ \Carbon\Carbon::parse($reserva->RESERVA_FECHA)->format('d/m/Y') }}</span>
                            <span class="dato-hora">{{ \Carbon\Carbon::parse($reserva->RESERVA_HORA)->format('H:i') }}</span>
                            <span class="dato-mesa">
                                @if($reserva->reservasMesas->count() > 0)
                                Mesa {{ $reserva->reservasMesas->first()->MESA_ID }}
                                @else
                                Por asignar
                                @endif
                            </span>
                            <span class="dato-comensales">{{ $reserva->RESERVA_COMENSALES }} personas</span>
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
                </div>
            </div>
            @endif

            {{-- SECCIÓN REPORTES --}}
            @if ($seccionActiva === 'reportes')
            <div class="seccion-reportes">
                <!-- FORMULARIO DE REPORTE -->
                <form action="{{ route('reportar',  $usuarioGlobal->USUARIO_ID) }}" method="POST">
                    @csrf

                    <!-- TABLA DE REPORTES -->
                    <main class="tabla-reportes">
                        <div class="etiquetas-reportes">
                            <div class="rectangle-reportes"></div>
                            <span class="titulo-reporte">ESCRIBE TU REPORTE AQUÍ</span>
                        </div>
                        <div class="area-reporte">
                            <textarea class="texto-reporte" name="Contenido" id="textoReporte" placeholder="Escribe tu reporte aquí..." rows="8">{{ old('Contenido') }}</textarea>
                        </div>
                    </main>

                    <!-- BOTÓN DE ENVIAR REPORTE -->
                    <footer class="btns-reporte">
                        <button type="submit" class="btn-enviar-reporte">
                            <div class="rectangle-enviar"></div>
                            <span class="texto-enviar">ENVIAR REPORTE</span>
                        </button>
                    </footer>
                </form>
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

    // Funciones para datos personales
    function editarPerfil() {
        // Redirigir a la vista de edición de perfil del empleado
        window.location.href = "{{ route('empleado.editar') }}";
    }
</script>
@endsection