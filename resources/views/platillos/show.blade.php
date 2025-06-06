@extends('layouts.app')
@section('content')
<div class="contenedor">

    <div class="bienvenida-admin">
        <p class="bienvenida-texto">Detalles del platillo: {{ $platillo->PLATILLO_NOMBRE }}</p>
    </div>

    <div class="section-perfil">
        <table class="tabla-perfil">
            <tr>
                <th>Nombre</th>
                <td>{{ $platillo->PLATILLO_NOMBRE }}</td>
            </tr>
            <tr>
                <th>Descripción</th>
                <td>{{ $platillo->PLATILLO_DESCRIPCION }}</td>
            </tr>
            <tr>
                <th>Imagen</th>
                <td>
                    @if($platillo->PLATILLO_IMAGEN)
                        <img src="{{ asset('storage/' . $platillo->PLATILLO_IMAGEN) }}" alt="Imagen del platillo" style="max-width: 200px;">
                    @else
                        Sin imagen
                    @endif
                </td>
            </tr>
            <tr>
                <th>Estado</th>
                <td>{{ $platillo->PLATILLO_STATUS }}</td>
            </tr>
        </table>
    </div>

    <a href="{{ route('admin.main', ['seccion' => 'menu']) }}" class="boton-admin" style="margin-top: 2px;">Volver</a>
</div>

<style>
    .tabla-perfil {
        width: 100%;
        border-collapse: collapse;
    }

    .tabla-perfil th,
    .tabla-perfil td {
        text-align: center;
        vertical-align: middle;
        padding: 8px;
    }

    .tabla-perfil img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
@endsection