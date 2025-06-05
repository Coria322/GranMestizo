
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mesa</title>
    <!-- Bootstrap CSS CDN
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">   -->
    @vite('resources/css/mesas/mesas.css')    
</head>
<body>

    
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="mb-0">Editar Mesa</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('mesas.update', $mesa->MESA_ID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="numero" class="form-label">ID de mesa</label>
                            <input type="text" id="numero" name="Id" value="{{ old('numero', $mesa->MESA_ID) }}" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="Capacidad" class="form-label">Capacidad</label>
                            <input type="number" class="form-control" id="Capacidad" name="Capacidad" value="{{ old('capacidad', $mesa->MESA_CAPACIDAD) }}" min="1" max="15" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="Seccion" class="form-label">Sección</label>
                            <input type="text" class="form-control" id="Seccion" name="Seccion" value="{{ old('ubicacion', $mesa->MESA_SECCION) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="Estado" class="form-label">Estado</label>
                            <select class="form-select" id="Estado" name="Status" required>
                                <option value="LIBRE" {{ old('Estado', $mesa->MESA_ESTADO) == 'LIBRE' ? 'selected' : '' }}>LIBRE</option>
                                <option value="OCUPADO" {{ old('Estado', $mesa->MESA_ESTADO) == 'OCUPADO' ? 'selected' : '' }}>OCUPADO</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="{{ route('login') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>