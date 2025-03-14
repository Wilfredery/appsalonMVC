<h1 class="nombre-pagina">Crear nuevo servicio</h1>
<p class="descripcion-pagina">Llena todo los campos para agregar un nuevo servicio</p>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>
<?php include_once __DIR__ . '/../templates/errores.php'; ?>


<form action="/servicios/crear" method="POST" class="formulario">

    <?php include_once __DIR__. '/formulario.php'; ?>

    <input type="submit" class="boton" value="Guardar">
</form>