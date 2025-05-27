@if (session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

@if (session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif

<div class="container">
    <h2>Editar Mesa</h2>
    <form action="{{ route('mesas.update', $mesa->MESA_ID) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="numero">ID de mesa</label>
            <input type="text" id="numero" name="Id" value="{{ old('numero', $mesa->MESA_ID) }}" readonly>
        </div>

        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <input type="number" class="form-control" id="Capacidad" name="Capacidad" value="{{ old('capacidad', $mesa->MESA_CAPACIDAD) }}" min="1" max="15" required>
        </div>

        <div class="mb-3">
            <label for="Sección" class="form-label">Sección</label>
                <input type="text" class="form-control" id="Seccion" name="Seccion" value="{{ old('ubicacion', $mesa->MESA_SECCION) }}" required>
        </div>

        <div class="mb-3">
            <label for="Estado" class="form-label">Estado</label>
            <select class="form-control" id="Estado" name="Status" required>
                <option value="LIBRE" {{ old('Estado', $mesa->MESA_ESTADO) == 'LIBRE' ? 'selected' : '' }}>LIBRE</option>
                <option value="OCUPADO" {{ old('Estado', $mesa->MESA_ESTADO) == 'OCUPADO' ? 'selected' : '' }}>OCUPADO</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('login') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>