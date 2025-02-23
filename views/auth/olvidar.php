<h1 class="nombre-pagina">Olvide el password</h1>
<p class="descripcion-pagina">Escribir tu correo para reestablecer el password</p>

<?php 

    include_once __DIR__ . '/../templates/errores.php';
?>

<form action="/olvidar" class="formulario" method="POST">
    <div class="campo">

        <label for="email">Email: </label>
        <input type="email" name="email" id="email" placeholder="Tu correo electronico">
    </div>

    <input type="submit" class="boton" value="Enviar">
</form>

<div class="acciones">
    <a href="/">Iniciar sesion</a>
    <a href="/crear">Crear cuenta</a>
</div>