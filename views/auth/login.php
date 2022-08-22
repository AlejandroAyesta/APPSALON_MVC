<h1 class="nombre-pag">Login</h1>
<p class="descripcion-pag">Inicia Sesión con tus datos</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="form" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu Email" name="email">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="Tu Contraseña" name="password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/crear">Crear una cuenta</a>
    <a href="/olvide">Olvidé mi contraseña</a>
</div>