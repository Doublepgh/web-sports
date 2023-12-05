<?php
$tipoUsuario = "admin_secure123";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Deportes en Línea</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>

    <header>
        <h1>SPORT SIGLO XXI</h1>
    </header>

    <nav>
        <a href="vistaAdminMss.php">Inicio</a>
        <a href="#">Mensajes</a>
        <a href="#" onclick="cerrarSesion()">Cerrar Sesión</a>
    </nav>



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
