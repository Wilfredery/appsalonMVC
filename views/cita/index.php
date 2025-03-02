<h1 class="nombre-pagina">Crear nueva cita</h1>
<p class="descripcion-pagina">Elige los servicios y procede a colocar tus datos</p>

<div id="app">

    <nav class="tabs">
        <button type="button" class="actual"  data-paso='1'>Servicios</button>
        <button type="button" data-paso='2'>Información de cita</button>
        <button type="button" data-paso='3'>Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios</p>
        <div class="listado-servicios" id="servicios"></div>
    </div>

    <div id="paso-2" class="seccion">
        <h2>Datos y cita</h2>
        <p class="text-center">Colocar tus datos y fecha de la cita</p>
        
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" placeholder="Escribir tu nombre" value="<?php echo $nombre; ?>" readonly>
            </div>


            <div class="campo">
                <label for="fecha">Fecha: </label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>



            <div class="campo">
                <label for="hora">Hora: </label>
                <input type="time" id="hora">
            </div>
        </form>

    </div>

    <div id="paso-3" class="seccion">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta</p>
    </div>

    <div class="paginacion">

        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>

</div>

<?php
            $script = '

                <script src="build/js/app.js"></script>
            ';
        ?>

