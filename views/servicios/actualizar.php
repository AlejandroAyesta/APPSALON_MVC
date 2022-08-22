<h1 class="nombre-pag">Actualizar Servicio</h1>
<p class="descripcion-pag">Modifica los valores del formulario</p>

<?php   
    // include_once __DIR__ . '/../templates/barra.php'; 
    include_once __DIR__ . '/../templates/alertas.php'; 
?>

<form method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <div class="acciones-crear">
        <input type="submit" class="boton" value="Actualizar Servicio">
        <a href="/servicios" class="boton">Volver</a>
    </div>
</form>