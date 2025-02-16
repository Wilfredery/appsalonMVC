<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Iniciar sesion con tus datos</p>

<form action="/" class="formulario" method="POST">

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu correo" name="email">

    </div>

    <div class="campo">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu contraseña">
    </div>

    <input type="submit" value="SEND" class="boton">
</form>

<div class="acciones">
    <a href="/crearcuenta">Crear aqui si no tienes una cuenta</a>
    <a href="/olvidar">Presionar aqui si olvidaste tu contra</a>
</div>