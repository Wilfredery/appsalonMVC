<h1 class="nombre-pagina">Crear nueva cita</h1>
<p class="descripcion-pagina">Elige los servicios y procede a colocar tus datos</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
?>

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
                <input type="date" id="fecha" min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="campo">
                <label for="hora">Hora: </label>
                <input type="time" id="hora">
            </div>

            <input type="hidden"id="id" value="<?php echo $id; ?>">

        </form>

    </div>

    <div id="paso-3" class="seccion contenido-resumen">
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="build/js/app.js"></script>
    ';
?>

