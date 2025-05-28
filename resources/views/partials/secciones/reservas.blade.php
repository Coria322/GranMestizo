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
            <button class="boton-admin bon" id="btn-ver-reserva">Ver Reserva</button>
            <button class="boton-admin bon" id="btn-eliminar-reserva">Eliminar Reserva</button>
        </div>
    </div>
