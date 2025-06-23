<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Platillo</title>
    @vite('resources/css/platillos/edit.css')
</head>
<body>
    <div class="container">
        <div class="form-card">
            <div class="form-header">
                <h2>Editar Platillo</h2>
            </div>
            
            <div class="form-body">
                <form action="{{ route('platillos.update', $platillo->PLATILLO_ID) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="PLATILLO_NOMBRE" class="form-label">Nombre del Platillo</label>
                        <input type="text" class="form-control @error('PLATILLO_NOMBRE') is-invalid @enderror" 
                        id="PLATILLO_NOMBRE" name="PLATILLO_NOMBRE" 
                        value="{{ old('PLATILLO_NOMBRE', $platillo->PLATILLO_NOMBRE) }}" 
                        placeholder="Ej: Tacos al Pastor" required>
                        @error('PLATILLO_NOMBRE')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="PLATILLO_DESCRIPCION" class="form-label">Descripción</label>
                        <textarea class="form-control @error('PLATILLO_DESCRIPCION') is-invalid @enderror" 
                        id="PLATILLO_DESCRIPCION" name="PLATILLO_DESCRIPCION"
                        placeholder="Describe los ingredientes y preparación del platillo...">{{ old('PLATILLO_DESCRIPCION', $platillo->PLATILLO_DESCRIPCION) }}</textarea>
                        @error('PLATILLO_DESCRIPCION')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="PLATILLO_IMAGEN" class="form-label">Imagen del Platillo</label>
                        <input type="file" class="form-control @error('PLATILLO_IMAGEN') is-invalid @enderror" 
                        id="PLATILLO_IMAGEN" name="PLATILLO_IMAGEN" accept="image/*">
                        @error('PLATILLO_IMAGEN')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if ($platillo->PLATILLO_IMAGEN)
                        <div class="image-preview">
                            <span class="image-label">Imagen Actual</span>
                            <img src="{{ asset('storage/' . $platillo->PLATILLO_IMAGEN) }}" 
                                 alt="Imagen actual del platillo" 
                                 class="img-thumbnail">
                        </div>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label for="PLATILLO_STATUS" class="form-label">Estado</label>
                        <select class="form-select @error('PLATILLO_STATUS') is-invalid @enderror" 
                        id="PLATILLO_STATUS" name="PLATILLO_STATUS" required>
                            <option value="">Seleccionar estado...</option>
                            <option value="activo" {{ old('PLATILLO_STATUS', $platillo->PLATILLO_STATUS) == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('PLATILLO_STATUS', $platillo->PLATILLO_STATUS) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('PLATILLO_STATUS')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="button-container">
                        <button type="submit" class="btn btn-primary">
                            <span>Actualizar Platillo</span>
                        </button>
                        <a href="{{ route('platillos.cancel') }}" class="btn btn-secondary">
                            <span>Cancelar</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>