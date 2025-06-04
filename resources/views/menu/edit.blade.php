@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Platillo</h2>

    <form action="{{ route('platillos.update', $platillo->PLATILLO_ID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="PLATILLO_NOMBRE" class="form-label">Nombre</label>
            <input type="text" class="form-control @error('PLATILLO_NOMBRE') is-invalid @enderror" 
                   id="PLATILLO_NOMBRE" name="PLATILLO_NOMBRE" value="{{ old('PLATILLO_NOMBRE', $platillo->PLATILLO_NOMBRE) }}" required>
            @error('PLATILLO_NOMBRE')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="PLATILLO_DESCRIPCION" class="form-label">Descripción</label>
            <textarea class="form-control @error('PLATILLO_DESCRIPCION') is-invalid @enderror" 
                      id="PLATILLO_DESCRIPCION" name="PLATILLO_DESCRIPCION">{{ old('PLATILLO_DESCRIPCION', $platillo->PLATILLO_DESCRIPCION) }}</textarea>
            @error('PLATILLO_DESCRIPCION')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="PLATILLO_IMAGEN" class="form-label">Imagen</label>
            <input type="file" class="form-control @error('PLATILLO_IMAGEN') is-invalid @enderror" 
                   id="PLATILLO_IMAGEN" name="PLATILLO_IMAGEN" accept="image/*">
            @error('PLATILLO_IMAGEN')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($platillo->PLATILLO_IMAGEN)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $platillo->PLATILLO_IMAGEN) }}" alt="Imagen actual" class="img-thumbnail" width="150">
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="PLATILLO_STATUS" class="form-label">Estado</label>
            <select class="form-select @error('PLATILLO_STATUS') is-invalid @enderror" 
                    id="PLATILLO_STATUS" name="PLATILLO_STATUS" required>
                <option value="activo" {{ old('PLATILLO_STATUS', $platillo->PLATILLO_STATUS) == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ old('PLATILLO_STATUS', $platillo->PLATILLO_STATUS) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('PLATILLO_STATUS')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('platillos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
