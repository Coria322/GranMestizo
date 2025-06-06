<div id="section-platillos" class="section">
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Status</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($platillos as $platillo)
                <tr class="fila-platillo selectable-row"
                    data-id="{{ $platillo->PLATILLO_ID }}"
                    data-nombre="{{ $platillo->PLATILLO_NOMBRE }}"
                    data-descripcion="{{ $platillo->PLATILLO_DESCRIPCION }}"
                    data-imagen="{{ $platillo->PLATILLO_IMAGEN }}"
                    data-status="{{ $platillo->PLATILLO_STATUS }}"
                    >
                    <td>{{ $platillo->PLATILLO_ID }}</td>
                    <td>{{ $platillo->PLATILLO_NOMBRE }}</td>
                    <td>{{ Str::limit($platillo->PLATILLO_DESCRIPCION, 50) }}</td>
                    <td>{{ strtoupper($platillo->PLATILLO_STATUS) }}</td>
                    <td>
                        @if ($platillo->PLATILLO_IMAGEN)
                            <img src="{{ asset('storage/' . $platillo->PLATILLO_IMAGEN) }}" alt="Imagen" width="50">
                        @else
                            Sin imagen
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay platillos registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="paginacion">
        {{ $platillos->appends(['seccion' => 'menu'])->links() }}
    </div>

    <div class="acciones-adm">
        <button class="boton-admin bon" id="btn-crearPlatillo">Crear platillo</button>
        <button class="boton-admin bon" id="btn-verPlatillo" disabled>Ver platillo</button>
        <button class="boton-admin bon" id="btn-estadoPlatillo" disabled>Cambiar estado</button>
        <button class="boton-admin bon" id="btn-eliminarPlatillo" disabled>Eliminar platillo</button>
        <button class="boton-admin bon" id="btn-modificarPlatillo" disabled>Modificar platillo</button>
        <button class="boton-admin bon" id="btn-limpiarP">Limpiar Selección</button>
    </div>

    {{-- Formulario oculto para Modificar --}}
    <form id="form-estado-platillo" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    {{-- Formulario oculto para eliminar --}}
    <form id="form-eliminar-platillo" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<style>
    .tabla-admin td, .tabla-admin th {
        text-align: justify;
    }
</style>
