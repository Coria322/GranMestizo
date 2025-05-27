let usuarioSeleccionado = null;

document.addEventListener('DOMContentLoaded', function () {
    // Activar selección de filas
    const filasUsuarios = document.querySelectorAll('.selectable-row');
    filasUsuarios.forEach(fila => {
        fila.addEventListener('click', function () {
            seleccionarUsuario(this);
        });
    });

    // Conectar botones
    const btnVer = document.getElementById('btn-ver-usuario');
    const btnEliminar = document.getElementById('btn-eliminar-usuario');
    const btnModificar = document.getElementById('btn-modificar-usuario');
    const btnLimpiar = document.getElementById('btn-limpiar')

    if (btnVer) {
        btnVer.addEventListener('click', verUsuario);
    }

    if (btnEliminar) {
        btnEliminar.addEventListener('click', eliminarUsuario);
    }

    if (btnModificar) {
        btnModificar.addEventListener('click', modificarUsuario);
    }

    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', limpiarSeleccion)
    }
});

function seleccionarUsuario(fila) {
    document.querySelectorAll('.selectable-row').forEach(f => f.classList.remove('selected'));

    fila.classList.add('selected');

    const id = fila.getAttribute('data-id');
    const nombre = fila.getAttribute('data-nombre');
    const apellido = fila.getAttribute('data-apellido');
    const correo = fila.getAttribute('data-correo');
    const rol = fila.getAttribute('data-rol');

    usuarioSeleccionado = { id, nombre, apellido, correo, rol };

    document.getElementById('info-id').textContent = id;
    document.getElementById('info-nombre').textContent = nombre;
    document.getElementById('info-apellido').textContent = apellido;
    document.getElementById('info-correo').textContent = correo;
    document.getElementById('info-rol').textContent = rol;

    document.getElementById('btn-ver-usuario').disabled = false;
    document.getElementById('btn-eliminar-usuario').disabled = false;
    document.getElementById('btn-modificar-usuario').disabled = false;

    document.getElementById('form-eliminar-usuario').action = `/admin/usuarios/eliminar/${id}`;
}

function verUsuario() {
    if (usuarioSeleccionado) {
        window.location.href = `/admin/usuarios/${usuarioSeleccionado.id}`;
    }
}

function eliminarUsuario() {
    if (usuarioSeleccionado) {
        const confirmacion = confirm(`¿Estás seguro de eliminar al usuario ${usuarioSeleccionado.nombre} ${usuarioSeleccionado.apellido}?`);
        if (confirmacion) {
            document.getElementById('form-eliminar-usuario').submit();
        }
    }
}

function modificarUsuario() {
    if (usuarioSeleccionado) {
        window.location.href = `/admin/usuarios/${usuarioSeleccionado.id}/edit`;
    }
}

function limpiarSeleccion() {
    document.querySelectorAll('.selectable-row').forEach(f => f.classList.remove('selected'));

    document.getElementById('btn-ver-usuario').disabled = true;
    document.getElementById('btn-eliminar-usuario').disabled = true;
    document.getElementById('btn-modificar-usuario').disabled = true;

    usuarioSeleccionado = null;
}
