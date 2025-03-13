<div class="barra">
    <p>Hola: <?php echo $nombre ?? ''; ?> </p>

    <a class="boton" href="/logout">Cerrar Sesion</a>
</div>

<?php if(isset($_SESSION['administrador'])) { ?>

    <div class="barra-servicios">
    <a class="boton" href="/admin">Ver citas</a>
    <a class="boton" href="/servicios">Ver servicios</a>
    <a class="boton" href="/servicios/crear">Nuevo servicios</a>
    </div>
<?php } ?>