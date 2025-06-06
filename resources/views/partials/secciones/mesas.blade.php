<div id="section-mesas" class="section">
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Capacidad</th>
                <th>Estado</th>
                <th>Seccion</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mesas as $mesa)
            <tr class="fila-mesa selectable-row"
                data-id="{{ $mesa->MESA_ID }}"
                data-capacidad="{{ $mesa->MESA_CAPACIDAD }}"
                data-status="{{ $mesa->MESA_STATUS }}"
                data-seccion="{{ $mesa->MESA_SECCION }}">
                <td>{{ $mesa->MESA_ID }}</td>
                <td>{{ $mesa->MESA_CAPACIDAD }}</td>
                <td>{{ $mesa->MESA_STATUS }}</td>
                <td>{{ $mesa->MESA_SECCION }}</td>
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
        <button class="boton-admin bon" id="btn-crearMesa">Crear mesa</button>
        <button class="boton-admin bon" id="btn-verMesa" disabled>Ver mesa</button>
        <button class="boton-admin bon" id="btn-eliminarMesa" disabled>Eliminar mesa</button>
        <button class="boton-admin bon" id="btn-modificarMesa" disabled>Modificar mesa</button>
        <button class="boton-admin bon" id="btn-limpiarM">Limpiar Selección</button>
    </div>
    {{-- Formulario oculto para eliminar --}}
    <form id="form-eliminar-mesa" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>  