<h1 class="nombre-pagina">Panel de administración</h1>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
?>

<h2>Busqueda de citas</h2>
<div class="busqueda">
    <form class="formulario" action="">
        <div class="campo">
            <label for="fecha">Fecha: </label>
            <input type="date" id="fecha" value=<?php echo $fecha; ?> name="fecha">
        </div>
    </form>
</div>

<?php
//Count cuenta un arreglo.
    if(count($citas) === 0) {
        echo "<h2 class='nombre-pagina'>No hay citas hechas en esta fecha.</h2>";
    }

?>

<div id="citas-admin">
    <ul class="citas">

    <?php
    $idCita = 0;

    foreach($citas as $key => $cita) { 
        if($idCita !== $cita->id) {  
            $total = 0;
    ?>
        <li>
            <p>ID: <span><?php echo $cita->id; ?></span></p>
            <p>Hora: <span><?php echo $cita->hora; ?></span></p>
            <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
            <p>email cliente: <span><?php echo $cita->email; ?></span></p>
            <p>telefono cliente: <span><?php echo $cita->telefono; ?></span></p>
            <h3>Servicios seleccionados</h3>

            <?php 
            
                $idCita = $cita->id; } //fin if 
                $total += $cita->precio;

            ?>
            <p class="servicio"><?php echo $cita->servicio. " - ". $cita->precio; ?></p>
        <?php 
        
        $actual = $cita->id; //Retorna el id donde estamos
        $proximo = $citas[$key + 1]->id ?? 0; //Indice en el arreglo de la DB. Si marca undifined es porque llego al ultimo asi que coloco un 0.

        if(esUltimo($actual, $proximo)) { ?>
            <p class="total">Total: $<span><?php echo $total; ?></span></p>

            <form action="/api/eliminar" method="POST">
                <input type="hidden" name="id" value="<?php echo $cita->id; ?>">

                <input type="submit" class="boton-eliminar" value="Eliminar">
            </form>

        <?php } ?>
    <?php } //fin foreach ?>
    
    </ul>
</div>

<?php

$script = '<script src="build/js/buscador.js"></script>';

?>