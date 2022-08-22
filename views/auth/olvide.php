<h1 class="nombre-pag">Olvidé la contraseña</h1>
<p class="descripcion-pag">Reestablece tu contraseña escribiendo tú E-mail a continuación</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="formulario" action="/olvide" method="POST">

    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Tú E-mail">
    </div>

    <input type="submit" class="boton" value="Enviar intrucciones">
</form>

<div class="acciones">
    <a href="/">Iniciar Sesión</a>
    <a href="/crear">Crear cuenta</a>
</div>
