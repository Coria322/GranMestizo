<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Reservar Mesa</title>
</head>
<body>

<h2>Crear Reserva</h2>

<form id="reservaForm">
  <label for="fecha">Fecha:</label>
  <input type="date" id="fecha" name="fecha" required />

  <br><br>

  <label for="hora">Hora:</label>
  <select id="hora" name="hora" required>
    <!-- Horas disponibles se llenan con JS -->
  </select>

  <br><br>

  <label for="comensales">Número de comensales:</label>
  <input type="number" id="comensales" name="comensales" min="1" max="20" required />

  <br><br>

  <button type="submit">Reservar</button>
</form>

<script>
  // Horas disponibles para selección (puedes ajustar)
  const horasPosibles = [
    "07:00", "08:00", "09:00", "10:00", "11:00",
    "12:00", "13:00", "14:00", "15:00", "16:00",
    "17:00", "18:00", "19:00", "20:00", "21:00"
  ];

  const fechaInput = document.getElementById('fecha');
  const horaSelect = document.getElementById('hora');
  const reservaForm = document.getElementById('reservaForm');

  // Función para llenar selector de horas, deshabilitando las ocupadas
  function llenarHoras(horasOcupadas = []) {
    horaSelect.innerHTML = '';

    horasPosibles.forEach(hora => {
      const option = document.createElement('option');
      option.value = hora;
      option.textContent = hora;

      if (horasOcupadas.includes(hora)) {
        option.disabled = true;
        option.textContent += " (No disponible)";
      }

      horaSelect.appendChild(option);
    });
  }

  // Al cambiar fecha, consultamos disponibilidad
  fechaInput.addEventListener('change', () => {
    const fecha = fechaInput.value;
    if (!fecha) return;

    fetch(`/reservas/disponibilidad?fecha=${fecha}`)
      .then(response => response.json())
      .then(data => {
        llenarHoras(data.horasReservadas || []);
      })
      .catch(() => {
        // En caso de error, mostramos todas las horas disponibles
        llenarHoras([]);
      });
  });

  // Inicializamos con todas las horas habilitadas
  llenarHoras();

  // Envío del formulario (solo demo)
  reservaForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const data = {
      fecha: fechaInput.value,
      hora: horaSelect.value,
      comensales: document.getElementById('comensales').value,
      cliente_id: '3ad21d46-b' // Aquí pondrías el cliente real autenticado
    };

    console.log("Datos para reservar:", data);

    // Aquí podrías hacer fetch POST a /reservas para crear reserva
    alert("Simulación de envío de reserva. Implementa el POST según backend.");
  });
</script>

</body>
</html>
