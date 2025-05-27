let usuarioSeleccionado = null;
let mesaSeleccionada = null;

document.addEventListener('DOMContentLoaded', function () {
    // Activar selección de filas de usuario
    const filasUsuarios = document.querySelectorAll('.fila-usuario.selectable-row');
    filasUsuarios.forEach(fila => {
        fila.addEventListener('click', function () {
            seleccionarUsuario(this);
        });
    });

    //Activar la selección de filas de mesa
    const filasMesas = document.querySelectorAll('.fila-mesa.selectable-row');
    filasMesas.forEach(fila => {
        fila.addEventListener('click', function () {
            seleccionarMesa(this);
        });
    });

    // Conectar botones
    const btnVer = document.getElementById('btn-ver-usuario');
    const btnEliminar = document.getElementById('btn-eliminar-usuario');
    const btnModificar = document.getElementById('btn-modificar-usuario');
    const btnLimpiar = document.getElementById('btn-limpiar');
    const btnCrearM = document.getElementById('btn-crearMesa');
    const btnEliminarM = document.getElementById('btn-eliminarMesa');
    const btnModM = document.getElementById('btn-modificarMesa');
    const btnLimpiarM = document.getElementById('btn-limpiarM');7
    const btnVerM = document.getElementById('btn-verMesa');

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

    if (btnCrearM){
        btnCrearM.addEventListener('click', crearMesa);
    }

    if (btnVerM){
        btnVerM.addEventListener('click', verMesa);
    }

    if (btnEliminarM) {
        btnEliminarM.addEventListener('click', eliminarMesa);
    }

    if (btnModM) {
        btnModM.addEventListener('click', modificarMesa);
    }

    if (btnLimpiarM) {
        btnLimpiarM.addEventListener('click', limpiarSeleccionM);
    }

});

//Seleccionar 
function seleccionarUsuario(fila) {
    document.querySelectorAll('.fila-usuario.selectable-row').forEach(f => f.classList.remove('selected'));

    fila.classList.add('selected');

    const id = fila.getAttribute('data-id');
    const nombre = fila.getAttribute('data-nombre');
    const apellido = fila.getAttribute('data-apellido');
    const correo = fila.getAttribute('data-correo');
    const rol = fila.getAttribute('data-rol');

    usuarioSeleccionado = { id, nombre, apellido, correo, rol };


    document.getElementById('btn-ver-usuario').disabled = false;
    document.getElementById('btn-eliminar-usuario').disabled = false;
    document.getElementById('btn-modificar-usuario').disabled = false;

    document.getElementById('form-eliminar-usuario').action = `/admin/usuarios/eliminar/${id}`;
}

function seleccionarMesa(fila) {
    document.querySelectorAll('.fila-mesa.selectable-row').forEach(f => f.classList.remove('selected'));

    fila.classList.add('selected');

    const id = fila.getAttribute('data-id');
    const capacidad = fila.getAttribute('data-capacidad');
    const status = fila.getAttribute('data-status');
    const seccion = fila.getAttribute('data-seccion');

    mesaSeleccionada = { id, capacidad, status, seccion };

    document.getElementById('btn-eliminarMesa').disabled = false;
    document.getElementById('btn-modificarMesa').disabled = false;
    document.getElementById('btn-verMesa').disabled = false;

    document.getElementById('form-eliminar-mesa').action = `/admin/mesas/eliminar/${id}`;
}

//crear
function crearMesa() {
    window.location.href = '/admin/mesas/crear';
}
//ver
function verUsuario() {
    if (usuarioSeleccionado) {
        window.location.href = `/admin/usuarios/${usuarioSeleccionado.id}`;
    }
}

function verMesa() {
    if (mesaSeleccionada) {
        window.location.href = `/admin/mesas/${mesaSeleccionada.id}`;
    }
}

//eliminar
function eliminarUsuario() {
    if (usuarioSeleccionado) {
        const confirmacion = confirm(`¿Estás seguro de eliminar al usuario ${usuarioSeleccionado.nombre} ${usuarioSeleccionado.apellido}?`);
        if (confirmacion) {
            document.getElementById('form-eliminar-usuario').submit();
        }
    }
}

function eliminarMesa() {
    if (mesaSeleccionada) {
        const confirmacion = confirm(`¿Estás seguro de eliminar la mesa con ID ${mesaSeleccionada.id}?`);
        if (confirmacion) {
            document.getElementById('form-eliminar-mesa').submit();
        }
    }
}

//modificar
function modificarUsuario() {
    if (usuarioSeleccionado) {
        window.location.href = `/admin/usuarios/${usuarioSeleccionado.id}/edit`;
    }
}

function modificarMesa() {
    if (mesaSeleccionada) {
        window.location.href = `/admin/mesas/${mesaSeleccionada.id}/edit`;
    }
}

//deseleccionar
function limpiarSeleccion() {
    document.querySelectorAll('.selectable-row').forEach(f => f.classList.remove('selected'));

    document.getElementById('btn-ver-usuario').disabled = true;
    document.getElementById('btn-eliminar-usuario').disabled = true;
    document.getElementById('btn-modificar-usuario').disabled = true;

    usuarioSeleccionado = null;
}

function limpiarSeleccionM() {
    document.querySelectorAll('.selectable-row').forEach(f => f.classList.remove('selected'));

    document.getElementById('btn-eliminarMesa').disabled = true;
    document.getElementById('btn-modificarMesa').disabled = true;
    document.getElementById('btn-verMesa').disabled = true;

    mesaSeleccionada = null;
}