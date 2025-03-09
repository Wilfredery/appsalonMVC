<h1 class="nombre-pagina">Panel de administración</h1>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
?>

<h2>Busqueda de citas</h2>
<div class="busqueda">
    <form class="formulario" action="">
        <div class="campo">
            <label for="fecha">Fecha: </label>
            <input type="date" id="fecha" name="fecha">
        </div>
    </form>
</div>

<div id="citas-admin">
    <ul class="citas">

    <?php
    $idCita = 0;

    foreach($citas as $cita) { 
        if($idCita !== $cita->id) {  
            
    ?>
        <li>
            <p>ID: <span><?php echo $cita->id; ?></span></p>
            <p>Hora: <span><?php echo $cita->hora; ?></span></p>
            <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
            <p>email cliente: <span><?php echo $cita->email; ?></span></p>
            <p>telefono cliente: <span><?php echo $cita->telefono; ?></span></p>
            <h3>Servicios seleccionados</h3>
            <?php $idCita = $cita->id; } //fin if ?>
            <p class="servicio"><?php echo $cita->servicio; ?></p>
    <?php } //fin foreach ?>
    
    </ul>
</div>