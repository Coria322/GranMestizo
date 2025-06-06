<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Mesa</title>
    <!-- Bootstrap CSS CDN
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">   -->
    @vite('resources/css/mesas/mesas.css')    
</head>
<body>
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Crear Mesa</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('mesas.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Capacidad de la Mesa:</label>
                                <input type="number" id="nombre" name="Capacidad" min="1" max="15" required class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="seccion" class="form-label">Sección:</label>
                                <input type="text" id="seccion" name="Seccion" required class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select id="status" name="Status" required class="form-select">
                                    <option value="">Seleccione un estado</option>
                                    <option value="LIBRE">Disponible</option>
                                    <option value="OCUPADO">Ocupada</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success">Crear Mesa</button>
                                <a href="{{ route('admin.main', ['seccion' => 'mesas']) }}" class="btn btn-secondary">Volver a la lista de mesas</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>