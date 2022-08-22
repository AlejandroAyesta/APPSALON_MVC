<h1 class="nombre-pag">Nuevo Servicio</h1>
<p class="descripcion-pag">Llena todos los campos para añadir un nuevo servicio</p>

<?php   
    // include_once __DIR__ . '/../templates/barra.php'; 
    include_once __DIR__ . '/../templates/alertas.php'; 
?>

<form action="/servicios/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <div class="acciones-crear">
        <input type="submit" class="boton" value="Guardar Servicio">
        <a href="/servicios" class="boton">Volver</a>
    </div>
</form>

