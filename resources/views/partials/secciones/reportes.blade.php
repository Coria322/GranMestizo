<div id='section-reportes' class="section">
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Contenido</th>
                <th>Usuario</th>
                <th>Fecha de creación</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reportes as $reporte)
            <tr class="fila-reportes selectable-row"
                data-id="{{ $reporte->REPORTE_ID }}"
                data-contenido="{{ $reporte->REPORTE_CONTENIDO }}"
                data-usuario="{{ $reporte->USUARIO_ID }}"
                data-fecha="{{ $reporte->created_at }}"
            >
                <td>{{ $reporte->REPORTE_ID }}</td>
                <td>{{ $reporte->REPORTE_CONTENIDO }}</td>
                <td>
                    @if($reporte->usuario)
                        {{ $reporte->usuario->USUARIO_NOMBRE ?? $reporte->USUARIO_ID }}
                    @else
                        {{ $reporte->USUARIO_ID }}
                    @endif
                </td>
                <td>{{ $reporte->created_at ? $reporte->created_at->format('Y-m-d H:i') : '' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No hay reportes registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="paginacion">
        {{ $reportes->links() }}
    </div>
    <div class="acciones-adm">
        <button class="boton-admin bon" id="btn-verReporte" disabled>Ver Reporte</button>
        <button class="boton-admin bon" id="btn-eliminarReporte" disabled>Eliminar Reporte</button>
        <button class="boton-admin bon" id="btn-limpiarR">Limpiar seleccion</button>
    </div>
</div>
{{-- Formulario oculto para eliminar --}}
<form id="form-eliminar-reporte" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
