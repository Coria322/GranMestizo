@extends('layouts.app')
@section('head')
@vite('resources/js/components/calendar.js')
@endsection
@section('content')
<div class="contenedor-formulario">

  <div class="fondo-logo">
    <!-- La imagen se usa como fondo, no necesitas un <img> -->
    <div class="formulario-reserva">
      <h2>REGISTRA TU RESERVACIÓN AQUÍ</h2>
      <form method="POST" action="{{ route('reservas.store') }}">
        @csrf
        <h3>ID DE CLIENTE</h3>
        <input
          type="text"
          title='Este es tu ID de Cliente'
          name="cliente_id"
          placeholder="Nombre del cliente"
          readonly value="{{ $usuarioGlobal->USUARIO_ID }}">

        <h3>FECHA</h3>

        <input
          type="date"
          name="fecha"
          id="fecha"
          required
          min="{{ now()->addDay()->format('Y-m-d') }}"
          max="{{ now()->addDays(16)->format('Y-m-d') }}"
          aria-describedby="fechaHelp errorFecha">

        <p id="errorFecha" class="hidden" role="alert">Fecha no disponible para reservar.</p>



        <h3>HORA</h3>
        <select
          name="hora"
          id="hora"
          required
          disabled
          aria-describedby="errorHora">
          <option value="">Seleccione primero su fecha</option>
        </select>
        <div id="estado"></div>
        <p id="errorHora" class="hidden" role="alert">No hay horas disponibles para esta fecha.</p>
        <p id="loadingHora" class="hidden">Cargando horas disponibles...</p>

        <h3>CANTIDAD DE COMENSALES</h3>
        <!-- El numero podría ser algo sacado de constantes de negocio en bd a futuro -->
        <input type="number" name="comensales" placeholder="Cantidad de comensales" required min="1" max="15" step="1">
        
        <button type="submit" id="btnReservar">Continuar</button>
        <a href="/login" class="link-volver">Volver</a>
      </form>
    </div>
  </div>
</div>
@endsection