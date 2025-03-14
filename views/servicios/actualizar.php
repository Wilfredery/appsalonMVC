<h1 class="nombre-pagina">Actualizar servicios</h1>
<p class="descripcion-pagina">Administración de servicios</p>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>
<?php include_once __DIR__ . '/../templates/errores.php'; ?>


<form  method="POST" class="formulario">

    <?php include_once __DIR__. '/formulario.php'; ?>

    <input type="submit" class="boton" value="Actualizar">
</form>