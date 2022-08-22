<h1 class="nombre-pag">Recuperar contraseña</h1>
<p class="descripcion-pag">Coloca tu nueva contraseña aquí</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<?php if($error) return; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Nueva Contraseña">
    </div>
    <input type="submit" class="boton" value="Guardar Cambios">
</form>

<div class="acciones">
    <a href="/">Iniciar Sesión</a>
    <a href="/crear">Crear Cuenta</a>
</div>