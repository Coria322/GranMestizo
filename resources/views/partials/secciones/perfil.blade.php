<div class="section-perfil">
    <table class="tabla-perfil">
        @foreach ($usuarioGlobal->getAttributes() as $key => $value )
        @if (!in_array($key, ['USUARIO_PWD']))
        @php
        $partes = explode('_', $key);
        $label = isset($partes[1])
        ? ucfirst(strtolower($partes[1]))
        : ucfirst(strtolower($partes[0]));
        @endphp
        <tr>
            <th>{{ $label }}</th>
            <td>{{ $value }}</td>
        </tr>
        @endif
        @endforeach
    </table>
</div>
    <div class="acciones-adm">
        <a href="admin/usuarios/{{ $usuarioGlobal->USUARIO_ID }}/edit" class="boton-admin bon" id="btn-editar-admin">Editar mi información</a>
    </div>