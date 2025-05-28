    <div id="section-usuarios" class="section">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuarios as $usuario)
                <tr class="fila-usuario selectable-row"
                    data-id="{{ $usuario->USUARIO_ID }}"
                    data-nombre="{{ $usuario->USUARIO_NOMBRE }}"
                    data-apellido="{{ $usuario->USUARIO_APELLIDO }}"
                    data-correo="{{ $usuario->USUARIO_CORREO }}"
                    data-rol="{{ $usuario->USUARIO_ROL }}">
                    <td>{{ $usuario->USUARIO_ID }}</td>
                    <td>{{ $usuario->USUARIO_NOMBRE }}</td>
                    <td>{{ $usuario->USUARIO_APELLIDO }}</td>
                    <td>{{ $usuario->USUARIO_CORREO }}</td>
                    <td>{{ $usuario->USUARIO_ROL }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">No hay Usuarios registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="paginacion">
            {{ $usuarios->appends(['seccion' => 'usuarios'])->links() }}
        </div>


        <div class="acciones-adm">
            <button type="button" class="boton-admin bon" id="btn-ver-usuario" disabled>
                Ver usuario
            </button>
            <button type="button" class="boton-admin bon" id="btn-eliminar-usuario" disabled>
                Eliminar Usuario
            </button>
            <button type="button" class="boton-admin bon" id="btn-modificar-usuario" disabled>
                Modificar usuario
            </button>
            <button type="button" class="boton-admin bon" id="btn-limpiar">
                Limpiar Selección
            </button>
        </div>

        {{-- Formulario oculto para eliminar --}}
        <form id="form-eliminar-usuario" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>