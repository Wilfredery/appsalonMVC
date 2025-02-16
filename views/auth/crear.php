<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Llenar el siguiente formulario</p>

<form action="/crear" class="formulario" method="POST">
    <div class="campo">

        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" placeholder="Tu nombre">
    </div>

    <div class="campo">

        <label for="apellido">Apellido: </label>
        <input type="text" name="apellido" id="apellido" placeholder="Tu apellido">
    </div>

    <div class="campo">

        <label for="telefono">Telefono: </label>
        <input type="tel" name="telefono" id="telefono" placeholder="Tu telefono">
    </div>

    <div class="campo">

        <label for="email">Email: </label>
        <input type="email" name="email" id="email" placeholder="Tu correo electronico">
    </div>

    <div class="campo">

        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" placeholder="Tu contraseña">
    </div>

    <input type="submit" class="boton" value="Crear cuenta">
</form>

<div class="acciones">
    <a href="/">Iniciar sesion</a>
    <a href="/olvidar">Presionar aqui si olvidaste tu contra</a>
</div>