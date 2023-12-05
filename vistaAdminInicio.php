<?php
$tipoUsuario = "admin_secure123";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home admin</title>
    <link rel="stylesheet" href="style/adminInicio.css">
    
    <style>
   section {
    display: flex;
    /* max-width: 800px; */
    width: 100%;
    height: calc(100vh - (10px + 10px)); /* 100% de la altura visible menos el margen superior e inferior */
    margin-top: 10px;
    margin-right: 5px;
    /* margin-bottom: 10px; */
    justify-content: center; /* Centra la sección horizontalmente */
}
</style>




</head>
<body>

  
       
        <?php include 'header.html';?>
  

    <nav>
        <a href="vistaAdminInicio.php">Inicio</a>
        <a href="mensajesAdmin.php">Mensajes</a>
        <a href="#" onclick="cerrarSesion()">Cerrar Sesión</a>
    </nav>
    <center>
    <section>
       
   
      
       <img src="https://img.menzig.style/f/10400/10419-f2.jpg" alt="">
      
      
     
   </section>
    </center>
 
    

    <footer>
        © 2023 Tienda de Deportes en Línea
    </footer>

    <form id="formCerrarSesion" action="logout.php" method="POST" style="display: none;">
        <button class="btn btn-logout" type="submit">Cerrar Sesión</button>
    </form>

    <script>
        function cerrarSesion() {
            // Simula el envío del formulario de cierre de sesión
            document.getElementById('formCerrarSesion').submit();
        }
    </script>

</body>
</html>
