@extends('layouts.app')
@section('content')
<div class="contenedor">

    <div class="bienvenida-admin">
        <p class="bienvenida-texto">Detalles de {{ $mesa->MESA_ID }}</p>
    </div>

    <div class="section-perfil">
        <table class="tabla-perfil">
            @foreach ($mesa->getAttributes() as $key => $value )
                @php
                    $partes = explode('_', $key);
                    $label = isset($partes[1])
                        ? ucfirst(strtolower($partes[1]))
                        : ucfirst(strtolower($partes[0]));
                @endphp
                <tr>
                    <th>{{ $label }}</th>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    @if ($mesa->reservas && $mesa->reservas->isNotEmpty())
    <table class="tabla-perfil">
        <tr>
            <th colspan="5" style="background-color: var(--petrol-blue);">RESERVAS ASOCIADAS</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Comensales</th>
            <th>Estado</th>
        </tr>
        @foreach ($mesa->reservas as $reserva)
        <tr>
            <td>{{ $reserva->RESERVA_ID }}</td>
            <td>{{ $reserva->RESERVA_FECHA }}</td>
            <td>{{ $reserva->RESERVA_HORA }}</td>
            <td>{{ $reserva->RESERVA_COMENSALES }}</td>
            <td>
                {{ optional($reserva->reservasMesas->first())->STATUS ?? 'N/A' }}
            </td>
        </tr>
        @endforeach
    </table>
    @else
        <p>No hay reservas asociadas a esta mesa.</p>
    @endif

    <a href="{{ route('admin.main', ['seccion' => 'mesas']) }}" class="boton-admin" style="margin-top: 2px;">Volver</a>
</div>
    <style>
        .tabla-perfil tr,
        .tabla-perfil th,
        .tabla-perfil td {
            text-align: center;
        }
    </style>
@endsection
