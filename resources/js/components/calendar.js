document.addEventListener('DOMContentLoaded', () => {
    const fechaInput = document.getElementById('fecha');
    const horaSelect = document.getElementById('hora');
    const errorFecha = document.getElementById('errorFecha');
    const errorHora = document.getElementById('errorHora');
    const loadingHora = document.getElementById('loadingHora');
    const btnReservar = document.getElementById('btnReservar');

    async function cargarHoras(fecha) {
        console.log("Fecha seleccionada:", fecha);

        // Limpiar y resetear estado
        errorFecha.classList.add('hidden');
        errorHora.classList.add('hidden');
        loadingHora.classList.add('hidden');
        btnReservar.disabled = true;
        horaSelect.disabled = true;
        horaSelect.classList.add('deshabilitado'); // Agrega esta clase si tu CSS lo necesita
        horaSelect.innerHTML = '<option value="">Cargando...</option>';

        if (!fecha) {
            horaSelect.innerHTML = '<option value="">Seleccione primero su fecha</option>';
            return;
        }

        try {
            // Verificar si la fecha está bloqueada
            const fechasResp = await fetch("/reservas/fechas-bloqueadas");
            if (!fechasResp.ok) throw new Error('Error al consultar fechas bloqueadas');
            const fechasData = await fechasResp.json();
            console.log(fechasData)

            if (fechasData.fechasBloqueadas.includes(fecha)) {
                errorFecha.classList.remove('hidden');
                horaSelect.innerHTML = '<option value="">Fecha no disponible</option>';
                return;
            }

            // Cargar horas disponibles
            loadingHora.classList.remove('hidden');
            const res = await fetch(`/reservas/horas-disponibles?fecha=${fecha}`);
            loadingHora.classList.add('hidden');

            if (!res.ok) throw new Error('Error al cargar horas disponibles');
            const data = await res.json();

            if (data.horasDisponibles.length === 0) {
                horaSelect.innerHTML = '<option value="">No hay horas disponibles</option>';
                errorHora.classList.remove('hidden');
                return;
            }

            // Rellenar select con horas
            horaSelect.innerHTML = '';
            data.horasDisponibles.forEach(hora => {
                const option = document.createElement('option');
                option.value = hora;
                option.textContent = hora;
                horaSelect.appendChild(option);
            });

            horaSelect.disabled = false;
            horaSelect.classList.remove('deshabilitado');
            btnReservar.disabled = false;

        } catch (error) {
            console.error("Error cargando horas:", error);
            horaSelect.innerHTML = '<option value="">Error al cargar horas</option>';
        }
    }

    fechaInput.addEventListener('change', e => {
        cargarHoras(e.target.value);
    });

    btnReservar.disabled = true;
});
