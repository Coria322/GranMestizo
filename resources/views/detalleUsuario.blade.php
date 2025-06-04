@extends('layouts.app')
@section('content')
<div class="contenedor">

    <div class="bienvenida-admin">
        <p class="bienvenida-texto">Detalles de {{ $usuario->USUARIO_NOMBRE }}</p>
    </div>

    <div class="section-perfil">
        <table class="tabla-perfil">
            @foreach ($usuario->getAttributes() as $key => $value )
            @if (!in_array($key, ['USUARIO_PWD']))
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
            @endif
            @endforeach
        </table>

    </div>

    <table class="tabla-perfil">
        <tr>
            <th colspan="3" style="background-color: var(--petrol-blue);">
                DATOS DE {{ $usuario->USUARIO_ROL }}
            </th>
        </tr>
        @php
        switch ($usuario->USUARIO_ROL) {
        case 'ADMINISTRADOR':
        $perfil = $usuario->administrador;
        break;
        case 'EMPLEADO':
        $perfil = $usuario->empleado;
        break;
        case 'CLIENTE':
        $perfil = $usuario->cliente;
        break;
        default:
        $perfil = null;
        }
        @endphp

        @if ($perfil)
        @foreach ($perfil->getAttributes() as $key => $value)
        @if (!Str::endsWith($key, '_ID')) {{-- ocultar claves foráneas --}}
        @php
        $partes = explode('_', $key);
        $label = collect($partes)
        ->map(fn($p) => ucfirst(strtolower($p)))
        ->implode(' ');
        @endphp
        <tr>
            <th>{{ $label }}</th>
            <td>{{ $value }}</td>
        </tr>
        @endif
        @endforeach
        @else
        <tr>
            <td colspan="2">No hay datos disponibles para este perfil.</td>
        </tr>
        @endif
    </table>

    @if ($usuario->USUARIO_ROL === 'CLIENTE' && $usuario->cliente && $usuario->cliente->reservas->isNotEmpty())

    <table class="tabla-perfil">
        <tr>
            <th colspan="5" style="background-color: var(--petrol-blue);">RESERVAS</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Comensales</th>
            <th>Estado</th>
        </tr>
        @foreach ($usuario->cliente->reservas as $reserva)
        <tr>
            <td style="text-align: center;">{{ $reserva->RESERVA_ID }}</td>
            <td style="text-align: center;">{{ $reserva->RESERVA_FECHA }}</td>
            <td style="text-align: center;">{{ $reserva->RESERVA_HORA }}</td>
            <td style="text-align: center;">{{ $reserva->RESERVA_COMENSALES }}</td>
            <td style="text-align: center;">{{ $reserva->reservasMesas->first()->STATUS }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    @if ($usuario->USUARIO_ROL === 'EMPLEADO' && $usuario->empleado && $usuario->empleado->reservas->isNotEmpty())
    <table class="tabla-perfil">
        <tr>
            <th colspan="5" style="background-color: var(--petrol-blue);">RESERVAS</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Comensales</th>
            <th>Estado</th>
        </tr>
        @foreach ($usuario->empleado->reservas as $reserva)
        <tr>
            <td>{{ $reserva->RESERVA_ID }}</td>
            <td>{{ $reserva->RESERVA_FECHA }}</td>
            <td>{{ $reserva->RESERVA_HORA }}</td>
            <td>{{ $reserva->RESERVA_COMENSALES }}</td>
            <td>{{ $reserva->reservasMesas->first()->STATUS }}</td>
        </tr>
        @endforeach
    </table>
    @endif
    <a href="{{ route('admin.main') }}" class="boton-admin" style="margin-top: 2px;">Volver</a>
</div>
@endsection