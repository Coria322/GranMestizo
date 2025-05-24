<div class="container mx-auto p-4 max-w-md">
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1 class="text-2xl font-bold mb-4">Crear Reserva</h1>

    <form id="formReserva" method="POST" action="{{ route('reservas.store') }}">
        @csrf

        <input type="hidden" name="cliente_id" value="{{ auth()->user()->USUARIO_ID ?? '' }}">

        <div class="mb-4">
            <label for="fecha" class="block font-semibold mb-1">Fecha:</label>
            <input
                type="date"
                id="fecha"
                name="fecha"
                min="{{ date('Y-m-d') }}"
                required
                class="w-full border border-gray-300 rounded px-3 py-2"
                aria-describedby="fechaHelp errorFecha"
            >
            <small id="fechaHelp" class="text-gray-600 text-sm">Seleccione la fecha para su reserva.</small>
            <p id="errorFecha" class="text-red-600 text-sm mt-1 hidden" role="alert">Fecha no disponible para reservar.</p>
        </div>

        <div class="mb-4">
            <label for="hora" class="block font-semibold mb-1">Hora:</label>
            <select
                id="hora"
                name="hora"
                required
                disabled
                class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed"
                aria-live="polite"
                aria-describedby="errorHora"
            >
                <option value="">Seleccione una fecha primero</option>
            </select>
            <p id="errorHora" class="text-red-600 text-sm mt-1 hidden" role="alert">No hay horas disponibles para esta fecha.</p>
            <p id="loadingHora" class="text-gray-600 text-sm mt-1 hidden">Cargando horas disponibles...</p>
        </div>

        <div class="mb-4">
            <label for="comensales" class="block font-semibold mb-1">Número de comensales:</label>
            <input
                type="number"
                id="comensales"
                name="comensales"
                min="1"
                required
                class="w-full border border-gray-300 rounded px-3 py-2"
                value="1"
            >
        </div>

        <button
            type="submit"
            id="btnReservar"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
            disabled
        >
            Reservar
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const fechaInput = document.getElementById('fecha');
    const horaSelect = document.getElementById('hora');
    const errorFecha = document.getElementById('errorFecha');
    const errorHora = document.getElementById('errorHora');
    const loadingHora = document.getElementById('loadingHora');
    const btnReservar = document.getElementById('btnReservar');


async function cargarHoras(fecha) {
    console.log("Fecha seleccionada:", fecha);

    errorFecha.classList.add('hidden');
    errorHora.classList.add('hidden');
    loadingHora.classList.add('hidden');
    btnReservar.disabled = true;
    horaSelect.disabled = true;
    horaSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
    horaSelect.innerHTML = '<option value="">Cargando...</option>';

    if (!fecha) {
        console.log("No hay fecha seleccionada.");
        horaSelect.innerHTML = '<option value="">Seleccione una fecha primero</option>';
        return;
    }

    try {
        const fechasResp = await fetch("{{ route('reservas.fechas-bloqueadas') }}");
        if (!fechasResp.ok) throw new Error('Error al consultar fechas bloqueadas');
        const fechasData = await fechasResp.json();

        console.log("Fechas bloqueadas recibidas:", fechasData.fechasBloqueadas);

        if (fechasData.fechasBloqueadas.includes(fecha)) {
            console.warn("La fecha está bloqueada:", fecha);
            errorFecha.classList.remove('hidden');
            horaSelect.innerHTML = '<option value="">Fecha no disponible</option>';
            return;
        }

        loadingHora.classList.remove('hidden');
        const res = await fetch(`{{ route('reservas.horas-disponibles') }}?fecha=${fecha}`);

        console.log("Respuesta horas disponibles status:", res.status);

        loadingHora.classList.add('hidden');

        if (!res.ok) throw new Error('Error al cargar horas disponibles');

        const data = await res.json();

        console.log("Horas disponibles recibidas:", data.horasDisponibles);

        if (data.horasDisponibles.length === 0) {
            console.info("No hay horas disponibles para la fecha:", fecha);
            horaSelect.innerHTML = '<option value="">No hay horas disponibles</option>';
            errorHora.classList.remove('hidden');
            return;
        }

        horaSelect.innerHTML = '';
        data.horasDisponibles.forEach(hora => {
            const option = document.createElement('option');
            option.value = hora;
            option.textContent = hora;
            horaSelect.appendChild(option);
        });

        horaSelect.disabled = false;
        horaSelect.classList.remove('bg-gray-100', 'cursor-not-allowed');
        btnReservar.disabled = false;

    } catch (error) {
        console.error("Error cargando horas:", error);
        horaSelect.innerHTML = '<option value="">Error al cargar horas</option>';
    }
}


    fechaInput.addEventListener('change', e => {
        cargarHoras(e.target.value);
    });

    // Inicializamos botón deshabilitado si no hay fecha/hora
    btnReservar.disabled = true;

});
</script>
