<?php
$tipoUsuario = "Administrador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Deportes en Línea</title>
    <link rel="stylesheet" href="style/index.css">

    <style>
        
section{
    display: flex;
    width: 900px;
    height: 430px;
    margin-top: 50px;
}

section img{
    width: 0px;
    flex-grow: 1;
    object-fit: cover;
    opacity: .8;
    transition: .5s ease;

}
section img:hover{
    cursor: crosshair;
    width: 300px;
    opacity: 1;
    filter: contrast(120%);
}
    </style>
    

    
</head>
<body>
       
        <?php include 'header2.html';?>

    <nav>
        <a href="index.php">Inicio</a>
        <a href="login.php">Login</a>
        <a href="register.php">Registrar</a>
        <a href="contactanos.php">Contactanos</a>
      
    </nav>
    <center>
    <section>
       
       <img src="https://www.camisetassportclub.com/2021images/21argentinahome4.jpg" alt="">
       <img src="https://www.draftea.com/blog/wp-content/uploads/Camiseta-jersey-Francia-Qatar-Mundial-2022.jpeg" alt="">
       <img src="https://www.camisetassportclub.com/2021images/21argentinahome6.jpg" alt="">
       <img src="https://www.draftea.com/blog/wp-content/uploads/camisetas-selecciones-futbol-mundial-qatar-980x551.jpg" alt="">
       <img src="https://stadium-azteca.underdog.gs/soccerly/1/2020/08/03/1596493312.jpeg" alt="">
      
     
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
