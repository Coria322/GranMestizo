@extends('layouts.app')
@section('content')
<div class="contenedor">

    <div class="bienvenida-admin">
        <p class="bienvenida-texto">Detalles del reporte: {{ $reporte->REPORTE_ID }}</p>
    </div>

    <div class="section-perfil">
        <table class="tabla-perfil">
            <tr>
                <th>ID</th>
                <td>{{ $reporte->REPORTE_ID }}</td>
            </tr>
            <tr>
                <th>Contenido</th>
                <td>{{ $reporte->REPORTE_CONTENIDO }}</td>
            </tr>
            <tr>
                <th>Usuario</th>
                <td>
                    @if($reporte->usuario)
                        {{ $reporte->usuario->USUARIO_NOMBRE ?? 'Sin nombre' }} ({{ $reporte->USUARIO_ID }})
                    @else
                        {{ $reporte->USUARIO_ID }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <a href="{{ route('admin.main', ['seccion' => 'reportes']) }}" class="boton-admin" style="margin-top: 2px;">Volver</a>
</div>
<style>
    .tabla-perfil tr,
    .tabla-perfil th,
    .tabla-perfil td {
        text-align: center;
    }
</style>
@endsection
