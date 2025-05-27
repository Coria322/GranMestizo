@if ($errors->any())
    <script>
        alert("{{ implode('\n', $errors->all()) }}");
    </script>
@endif

@if (session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

<form action="{{ route('mesas.store') }}" method="POST">
    @csrf
    <div>
        <label for="nombre">Capacidad de la Mesa:</label>
        <input type="number" id="nombre" name="Capacidad" min="1" max="15" required>
    </div>
    <div>
        <label for="capacidad">Sección:</label>
        <input type="text" id="seccion" name="Seccion" required>
    </div>
    <div>
        <label for="status">Status:</label>
        <select id="status" name="Status" required>
            <option value="">Seleccione un estado</option>
            <option value="LIBRE">Disponible</option>
            <option value="OCUPADO">Ocupada</option>
        </select>
    </div>
    <button type="submit">Crear Mesa</button>
    <a href="{{ route('admin.main', ['seccion' => 'mesas']) }}">Volver a la lista de mesas</a>
</form>