{{-- Detalle de una reserva --}}
@extends('layouts.app')
@section('content')
<div class="contenedor">

    <div class="bienvenida-admin">
        <p class="bienvenida-texto">Detalles de la Reserva {{ $reserva->RESERVA_ID }}</p>
    </div>
    <div class="section-perfil">
        <table class="tabla-perfil">
            <tr>
                <th>ID</th>
                <td>{{ $reserva->RESERVA_ID }}</td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ $reserva->RESERVA_FECHA }}</td>
            </tr>
            <tr>
                <th>Hora</th>
                <td>{{ $reserva->RESERVA_HORA }}</td>
            </tr>
            <tr>
                <th>Comensales</th>
                <td>{{ $reserva->RESERVA_COMENSALES }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    {{ optional($reserva->reservasMesas->first())->STATUS ?? 'N/A' }}
                </td>
            </tr>
        </table>
    </div>

    <div class="bienvenida-admin">
        <p class="bienvenida-texto">Cliente</p>
    </div>
    <table class="tabla-perfil">
        <tr>
            <th>ID</th>
            <td>{{ $reserva->cliente->USUARIO_ID ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Nombre</th>
            <td>{{ $reserva->cliente->usuario->USUARIO_NOMBRE ?? 'Jhon' }}</td>
        </tr>
        <tr>
            <th>Apellido</th>
            <td>{{ $reserva->cliente->usuario->USUARIO_APELLIDO ?? 'Doe' }}</td>
        </tr>
        <tr>
            <th>RFC</th>
            <td>{{ $reserva->cliente->CLIENTE_RFC ?? 'XAXX010101000' }}</td>
        </tr>
        <tr>
            <th>Correo</th>
            <td>{{ $reserva->cliente->usuario->USUARIO_CORREO ?? 'N/A' }}</td>
        </tr>
    </table>

        <div class="bienvenida-admin">
            <p class="bienvenida-texto">
                Mesas asociadas
            </p>
        </div>
        @if ($reserva->mesas && $reserva->mesas->isNotEmpty())
        <table class="tabla-perfil">
            <tr>
                <th>ID Mesa</th>
                <th>Capacidad</th>
                <th>Sección</th>
                <th>Status</th>
            </tr>
            @foreach ($reserva->mesas as $mesa)
            <tr>
                <td>{{ $mesa->MESA_ID }}</td>
                <td>{{ $mesa->MESA_CAPACIDAD ?? 'N/A' }}</td>
                <td>{{ $mesa->MESA_SECCION ?? 'N/A' }}</td>
                <td>
                    {{ optional($mesa->reservasMesas->where('RESERVA_ID', $reserva->RESERVA_ID)->first())->STATUS ?? 'N/A' }}
                </td>
            </tr>
            @endforeach
        </table>
        @else
        <p>No hay mesas asociadas a esta reserva.</p>
        @endif

    <a href="{{ route('admin.main', ['seccion' => 'reservas']) }}" class="boton-admin" style="margin-top: 2px;">Volver</a>
</div>
<style>
    .tabla-perfil tr,
    .tabla-perfil th,
    .tabla-perfil td {
        text-align: center;
    }
</style>
@endsection