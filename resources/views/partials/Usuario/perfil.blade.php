<div class="seccion-perfil">
    <div class="tarjeta-perfil">
        <div class="header-perfil">
            <h2>MI PERFIL</h2>
        </div>
        <div class="contenido-perfil">
            <div class="info-usuario">
                <div class="campo-perfil">
                    <label>Nombre:</label>
                    <span>{{ $usuarioGlobal->USUARIO_NOMBRE }}</span>
                </div>
                <div class="campo-perfil">
                    <label>Apellido:</label>
                    <span>{{ $usuarioGlobal->USUARIO_APELLIDO }}</span>
                </div>
                <div class="campo-perfil">
                    <label>Correo:</label>
                    <span>{{ $usuarioGlobal->USUARIO_CORREO }}</span>
                </div>
                <div class="campo-perfil">
                    <label>RFC:</label>
                    <span>{{ $usuarioGlobal->cliente->CLIENTE_RFC ?? 'No disponible' }}</span>
                </div>
            </div>
            <div class="acciones-perfil">
                <button class="btn-editar-usuario" onclick="editarPerfil()">
                    EDITAR PERFIL
                </button>
            </div>
        </div>
    </div>
</div>