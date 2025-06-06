<div class="seccion-reportes">
    <!-- FORMULARIO DE REPORTE -->
    <form action="{{ route('cliente.reportar',  $usuarioGlobal->USUARIO_ID) }}" method="POST">
        @csrf

        <!-- TABLA DE REPORTES -->
        <main class="tabla-reportes">
            <div class="etiquetas-reportes">
                <div class="rectangle-reportes"></div>
                <span class="titulo-reporte">ESCRIBE TU REPORTE AQUÍ</span>
            </div>
            <div class="area-reporte">
                <textarea class="texto-reporte" name="Contenido" id="textoReporte" placeholder="Escribe tu reporte aquí..." rows="8">{{ old('Contenido') }}</textarea>
            </div>
        </main>

        <!-- BOTÓN DE ENVIAR REPORTE -->
        <footer class="btns-reporte">
            <button type="submit" class="btn-enviar-reporte">
                <div class="rectangle-enviar"></div>
                <span class="texto-enviar">ENVIAR REPORTE</span>
            </button>
        </footer>
    </form>
</div>