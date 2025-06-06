<div id="section-empleados" class="section">
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>RFC</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($empleados as $empleado)
            <tr class="fila-empleado selectable-row"
                data-id="{{ $empleado->USUARIO_ID }}"
                data-nombre="{{ $empleado->usuario->USUARIO_NOMBRE }}"
                data-apellido="{{ $empleado->usuario->USUARIO_APELLIDO }}"
                data-rfc="{{ $empleado->EMPLEADO_RFC }}">
                <td>{{ $empleado->USUARIO_ID }}</td>
                <td>{{ $empleado->usuario->USUARIO_NOMBRE }}</td>
                <td>{{ $empleado->usuario->USUARIO_APELLIDO }}</td>
                <td>{{ $empleado->EMPLEADO_RFC }}</td>
                <td>{{ $empleado->EMPLEADO_STATUS }}</td>
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
        <button type="button" class="boton-admin bon" id="btn-ver-usuario" disabled>Ver Empleado</button>
        <button type="button" class="boton-admin bon" id="btn-eliminar-usuario" disabled>Eliminar Empleado</button>
        <button type="button" class="boton-admin bon" id="btn-modificar-usuario" disabled>Modificar Empleado</button>
        <button type="button" class="boton-admin bon" id="btn-Limpiar-empleado">Limpiar selección</button>
    </div>
</div>
{{-- Formulario oculto para eliminar --}}
<form id="form-eliminar-usuario" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>