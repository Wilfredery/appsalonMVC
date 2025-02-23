<h1 class="nombre-pagina">Restablecer password</h1>
<p class="descripcion-pagina">Crear su nueva contraseña</p>

<?php 

    include_once __DIR__ . '/../templates/errores.php';
?>

<!-- Si el token no es valido que termine el proceso ahi mismo en el return -->
<?php if($noTokenValido) return; ?>

<form method="POST" class="formulario">

    <div class="campo">
        <label for="password">Password</label>

        <input type="password" name="password" placeholder="Tu nuevo password" id="password">
    </div>
    
    <input type="submit" value="Enviar nueva contra" class="boton">
</form>

<div class="acciones">
    <a href="/">Si ya tienes cuenta ve a iniciar sesion</a>
    <a href="/crear">Crear cuenta</a>
</div>