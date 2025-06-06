let usuarioSeleccionado = null;
let mesaSeleccionada = null;
let empleadoSeleccionado = null;
let tipoSeleccionActual = null; // 'usuario', 'mesa', 'empleado', 'reserva', 'platillo', 'reporte'
let reservaSeleccionada = null;
let platilloSeleccionado = null;
let reporteSeleccionado = null

document.addEventListener('DOMContentLoaded', function () {
    // Selección de filas
    activarSeleccion('.fila-usuario.selectable-row', seleccionarUsuario);
    activarSeleccion('.fila-mesa.selectable-row', seleccionarMesa);
    activarSeleccion('.fila-empleado.selectable-row', seleccionarEmpleado);
    activarSeleccion('.fila-reservas.selectable-row', seleccionarReserva)
    activarSeleccion('.fila-platillo.selectable-row', seleccionarPlatillo);
    activarSeleccion('.fila-reportes.selectable-row', seleccionarReporte);

    // Botones
    conectarBoton('btn-ver-usuario', verUsuario);
    conectarBoton('btn-eliminar-usuario', eliminarUsuario);
    conectarBoton('btn-modificar-usuario', modificarUsuario);
    conectarBoton('btn-limpiar', limpiarSeleccion);
    conectarBoton('btn-crearMesa', crearMesa);
    conectarBoton('btn-verMesa', verMesa);
    conectarBoton('btn-eliminarMesa', eliminarMesa);
    conectarBoton('btn-modificarMesa', modificarMesa);
    conectarBoton('btn-limpiarM', limpiarSeleccionM);
    conectarBoton('btn-limpiar-empleado', limpiarSeleccionE);
    conectarBoton('btn-ver-reserva', verReserva);
    conectarBoton('btn-eliminar-reserva', eliminarReserva);
    conectarBoton('btn-limpiarR', limpiarSeleccionR);
    conectarBoton('btn-crearPlatillo', crearPlatillo);
    conectarBoton('btn-verPlatillo', verPlatillo);
    conectarBoton('btn-eliminarPlatillo', eliminarPlatillo);
    conectarBoton('btn-modificarPlatillo', modificarPlatillo);
    conectarBoton('btn-limpiarP', limpiarSeleccionP);
    conectarBoton('btn-estadoPlatillo', estadoPlatillo);
    conectarBoton('btn-verReporte', verReporte);
    conectarBoton('btn-eliminarReporte', eliminarReporte);
    conectarBoton('btn-limpiarR', limpiarSeleccionRep);
});

function activarSeleccion(selector, handler) {
    document.querySelectorAll(selector).forEach(fila => {
        fila.addEventListener('click', function () {
            handler(this);
        });
    });
}

function conectarBoton(id, handler) {
    const btn = document.getElementById(id);
    if (btn) {
        btn.addEventListener('click', handler);
    }
}

function actualizarBotones(tipo) {
    // Desactivar todo
    document.querySelectorAll('.boton-admin.bon').forEach(btn => btn.disabled = true);

    if (tipo === 'usuario') {
        ['btn-ver-usuario', 'btn-eliminar-usuario', 'btn-modificar-usuario', 'btn-limpiar'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.disabled = false;
        });
    }

    if (tipo === 'empleado') {
        ['btn-ver-usuario', 'btn-eliminar-usuario', 'btn-modificar-usuario', 'btn-limpiar-empleado'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.disabled = false;
        });
    }

    if (tipo === 'mesa') {
        ['btn-verMesa', 'btn-eliminarMesa', 'btn-modificarMesa', 'btn-limpiarM'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.disabled = false;
        });
        document.getElementById('btn-crearMesa').disabled = false;
    }

    if (tipo === 'reserva') {
        ['btn-ver-reserva', 'btn-eliminar-reserva', 'btn-limpiarR'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.disabled = false;
        });
    }

    if (tipo === 'platillo') {
        ['btn-verPlatillo', 'btn-eliminarPlatillo', 'btn-modificarPlatillo', 'btn-limpiarP', 'btn-estadoPlatillo'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.disabled = false;
        });
        document.getElementById('btn-crearPlatillo').disabled = false;
    }

    if (tipo === 'reporte') {
        ['btn-verReporte', 'btn-eliminarReporte', 'btn-limpiarR'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.disabled = false;
        });
    }

}

// ================= SELECCIONADORES ===================
function seleccionarUsuario(fila) {
    limpiarTodoMenos('usuario');
    tipoSeleccionActual = 'usuario';

    fila.classList.add('selected');

    usuarioSeleccionado = {
        id: fila.getAttribute('data-id'),
        nombre: fila.getAttribute('data-nombre'),
        apellido: fila.getAttribute('data-apellido'),
        correo: fila.getAttribute('data-correo'),
        rol: fila.getAttribute('data-rol')
    };

    document.getElementById('form-eliminar-usuario').action = `/admin/usuarios/eliminar/${usuarioSeleccionado.id}`;
    actualizarBotones('usuario');
}

function seleccionarEmpleado(fila) {
    limpiarTodoMenos('empleado');
    tipoSeleccionActual = 'empleado';

    fila.classList.add('selected');

    empleadoSeleccionado = {
        id: fila.getAttribute('data-id'),
        nombre: fila.getAttribute('data-nombre'),
        apellido: fila.getAttribute('data-apellido'),
        rfc: fila.getAttribute('data-rfc'),
        status: fila.getAttribute('data-status')
    };

    document.getElementById('form-eliminar-usuario').action = `/admin/usuarios/eliminar/${empleadoSeleccionado.id}`;
    actualizarBotones('empleado');
}

function seleccionarMesa(fila) {
    limpiarTodoMenos('mesa');
    tipoSeleccionActual = 'mesa';

    fila.classList.add('selected');

    mesaSeleccionada = {
        id: fila.getAttribute('data-id'),
        capacidad: fila.getAttribute('data-capacidad'),
        status: fila.getAttribute('data-status'),
        seccion: fila.getAttribute('data-seccion')
    };

    document.getElementById('form-eliminar-mesa').action = `/admin/mesas/eliminar/${mesaSeleccionada.id}`;
    actualizarBotones('mesa');
}

function seleccionarReserva(fila) {
    limpiarTodoMenos('reserva');
    tipoSeleccionActual = 'reserva';

    fila.classList.add('selected');

    reservaSeleccionada = {
        id: fila.getAttribute('data-id'),
        fecha: fila.getAttribute('data-fecha'),
        hora: fila.getAttribute('data-hora'),
        nombreCliente: fila.getAttribute('data-cliente'),
        empleadoId: fila.getAttribute('data-empleado'),
        comensales: fila.getAttribute('data-comensales'),
        status: fila.getAttribute('data-status'),
        mesaId: fila.getAttribute('data-mesa-id')
    };

    document.getElementById('form-eliminar-reserva').action = `/admin/reservas/eliminar/${reservaSeleccionada.id}`;
    actualizarBotones('reserva');
}

function seleccionarPlatillo(fila) {
    limpiarTodoMenos('platillo');
    tipoSeleccionActual = 'platillo';

    fila.classList.add('selected');

    platilloSeleccionado = {
        id: fila.getAttribute('data-id'),
        nombre: fila.getAttribute('data-nombre'),
        descripcion: fila.getAttribute('data-descripcion'),
        status: fila.getAttribute('data-status'),
    };

    document.getElementById('form-eliminar-platillo').action = `/admin/platillos/eliminar/${platilloSeleccionado.id}`;
    actualizarBotones('platillo');
}

function seleccionarReporte(fila) {
    limpiarTodoMenos('reporte');
    tipoSeleccionActual = 'reporte';

    fila.classList.add('selected');

    reporteSeleccionado = {
        id: fila.getAttribute('data-id'),
        contenido: fila.getAttribute('data-contenido'),
        usuario: fila.getAttribute('data-usuario'),
        fecha: fila.getAttribute('data-fecha'),
    };


    actualizarBotones('reporte');
}

// ================= BOTONES ACCIONES ===================
function crearMesa() {
    window.location.href = '/admin/mesas/crear';
}

function verUsuario() {
    if (tipoSeleccionActual === 'usuario' && usuarioSeleccionado)
        window.location.href = `/admin/usuarios/${usuarioSeleccionado.id}`;
    else if (tipoSeleccionActual === 'empleado' && empleadoSeleccionado)
        window.location.href = `/admin/usuarios/${empleadoSeleccionado.id}`;
}


function modificarUsuario() {
    if (tipoSeleccionActual === 'usuario' && usuarioSeleccionado)
        window.location.href = `/admin/usuarios/${usuarioSeleccionado.id}/edit`;
    else if (tipoSeleccionActual === 'empleado' && empleadoSeleccionado)
        window.location.href = `/admin/usuarios/${empleadoSeleccionado.id}/edit`;
}

function eliminarUsuario() {
    const seleccionado = tipoSeleccionActual === 'usuario' ? usuarioSeleccionado : empleadoSeleccionado;
    if (seleccionado) {
        const confirmacion = confirm(`¿Estás seguro de eliminar a ${seleccionado.nombre} ${seleccionado.apellido}?`);
        if (confirmacion) {
            document.getElementById('form-eliminar-usuario').submit();
        }
    }
}

function verMesa() {
    if (mesaSeleccionada)
        window.location.href = `/admin/mesas/${mesaSeleccionada.id}`;
}

function modificarMesa() {
    if (mesaSeleccionada)
        window.location.href = `/admin/mesas/${mesaSeleccionada.id}/edit`;
}

function eliminarMesa() {
    if (mesaSeleccionada) {
        const confirmacion = confirm(`¿Estás seguro de eliminar la mesa ${mesaSeleccionada.id}?`);
        if (confirmacion) {
            document.getElementById('form-eliminar-mesa').submit();
        }
    }
}

function verReserva() {
    if (reservaSeleccionada)
        window.location.href = `/admin/reservas/${reservaSeleccionada.id}`;
}

function eliminarReserva() {
    if (reservaSeleccionada) {
        const confirmacion = confirm(`¿Estás seguro de eliminar la reserva del cliente ${reservaSeleccionada.nombreCliente} para la fecha ${reservaSeleccionada.fecha} a las ${reservaSeleccionada.hora}?`);
        if (confirmacion) {
            document.getElementById('form-eliminar-reserva').submit();
        }
    }
}

function crearPlatillo() {
    window.location.href = '/admin/platillos/crear';
}

function verPlatillo() {
    if (platilloSeleccionado)
        window.location.href = `/admin/platillos/${platilloSeleccionado.id}`;
}

function modificarPlatillo() {
    if (platilloSeleccionado) {
        window.location.href = `/admin/platillos/${platilloSeleccionado.id}/edit`;
    }
}

function eliminarPlatillo() {
    if (platilloSeleccionado) {
        const confirmacion = confirm(`¿Estás seguro de eliminar el platillo ${platilloSeleccionado.nombre}?`);
        if (confirmacion) {
            document.getElementById('form-eliminar-platillo').submit();
        }
    }
}

function estadoPlatillo() {
    if (platilloSeleccionado) {
        const confirmacion = confirm(`¿Estás seguro de cambiar el estado del platillo ${platilloSeleccionado.nombre}?`);
        if (confirmacion) {
            const form = document.getElementById('form-estado-platillo');
            form.action = `/admin/platillos/${platilloSeleccionado.id}/estado`;
            form.submit();
        }
    }
}

function verReporte() {
    if (reporteSeleccionado)
        window.location.href = `/admin/reportes/${reporteSeleccionado.id}`;
}

function eliminarReporte() {
    if (reporteSeleccionado) {
        const confirmacion = confirm(`¿Estás seguro de eliminar el reporte ${reporteSeleccionado.id}?`);
        if (confirmacion) {
            const form = document.getElementById('form-eliminar-reporte');
            form.action = `/admin/reportes/eliminar/${reporteSeleccionado.id}`;
            form.submit();
        }
    }
}


function limpiarSeleccionR() {
    limpiarTodoMenos(null);
    reservaSeleccionada = null;
    tipoSeleccionActual = null;

    // Desactivar botones relacionados con reservas
    ['btn-ver-reserva', 'btn-eliminar-reserva'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.disabled = true;
    });

    // Mantener el botón de limpiar activo
    const btnLimpiarR = document.getElementById('btn-limpiarR');
    if (btnLimpiarR) btnLimpiarR.disabled = false;
}

// ================= LIMPIAR ===================
function limpiarTodoMenos(excepto) {
    document.querySelectorAll('.selectable-row').forEach(f => f.classList.remove('selected'));
    if (excepto !== 'usuario') usuarioSeleccionado = null;
    if (excepto !== 'empleado') empleadoSeleccionado = null;
    if (excepto !== 'mesa') mesaSeleccionada = null;
    tipoSeleccionActual = excepto;
}

function limpiarSeleccion() {
    limpiarTodoMenos(null);
    usuarioSeleccionado = null;
    tipoSeleccionActual = null;

    // Desactivar botones relacionados con usuarios
    ['btn-ver-usuario', 'btn-eliminar-usuario', 'btn-modificar-usuario'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.disabled = true;
    });

    // Mantener el botón de limpiar activo
    const btnLimpiar = document.getElementById('btn-limpiar');
    if (btnLimpiar) btnLimpiar.disabled = false;
}

function limpiarSeleccionM() {
    limpiarTodoMenos(null);
    mesaSeleccionada = null;
    tipoSeleccionActual = null;

    ['btn-verMesa', 'btn-eliminarMesa', 'btn-modificarMesa'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.disabled = true;
    });

    const btnLimpiarM = document.getElementById('btn-limpiarM');
    if (btnLimpiarM) btnLimpiarM.disabled = false;
}

function limpiarSeleccionE() {
    limpiarTodoMenos(null);
    empleadoSeleccionado = null;
    tipoSeleccionActual = null;

    ['btn-ver-usuario', 'btn-eliminar-usuario', 'btn-modificar-usuario'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.disabled = true;
    });

    const btnLimpiarE = document.getElementById('btn-limpiar-empleado');
    if (btnLimpiarE) btnLimpiarE.disabled = false;
}

function limpiarSeleccionP() {
    limpiarTodoMenos(null);
    platilloSeleccionado = null;
    tipoSeleccionActual = null;

    ['btn-verPlatillo', 'btn-eliminarPlatillo', 'btn-modificarPlatillo', 'btn-estadoPlatillo'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.disabled = true;
    });

    const btnLimpiarP = document.getElementById('btn-limpiarP');
    if (btnLimpiarP) btnLimpiarP.disabled = false;
}

function limpiarSeleccionRep() {
    limpiarTodoMenos(null);
    reporteSeleccionado = null;
    tipoSeleccionActual = null;

    ['btn-verReporte', 'btn-eliminarReporte'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.disabled = true;
    });

    const btnLimpiarRep = document.getElementById('btn-limpiarR');
    if (btnLimpiarRep) btnLimpiarRep.disabled = false;
}