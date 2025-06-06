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
