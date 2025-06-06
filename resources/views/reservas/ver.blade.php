<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<div class="container">
    <h1 class="mb-4">Listado de Reservas</h1>
    <a href="{{ route('reservas.index', ['id_us' => $usuarioGlobal->USUARIO_ID]) }}">Ver reservas de este usuario</a>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($reservas->isEmpty())
        <p>No hay reservas registradas.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Empleado</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Comensales</th>
                    <th>Mesas</th>
                    <th>Estado (Pivote)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->RESERVA_ID }}</td>
                        <td>{{ $reserva->cliente->USUARIO_ID }}</td>
                        <td>{{ $reserva->empleado->USUARIO_ID }}</td>
                        <td>{{ $reserva->RESERVA_FECHA }}</td>
                        <td>{{ $reserva->RESERVA_HORA }}</td>
                        <td>{{ $reserva->RESERVA_COMENSALES }}</td>
                        <td>
                            @foreach($reserva->mesas as $mesa)
                                {{ $mesa->MESA_ID }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($reserva->mesas as $mesa)
                                {{ $mesa->pivot->STATUS }}<br>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
