<?php
$tipoUsuario = "admin_secure123";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="style/adminInicio.css">
   
    
    
</head>

<body>
<div class="container">
          
<?php include 'header.html';?>
  

  <nav>
      <a href="vistaAdminInicio.php">Inicio</a>
      <a href="mensajesAdmin.php">Mensajes</a>
      <a href="#" onclick="cerrarSesion()">Cerrar Sesión</a>
  </nav>
        <div>
            <?php 
            require 'database.php';

            if (!extension_loaded('openssl')) {
                die("La extensión OpenSSL no está habilitada en tu servidor.");
            }

            // Cargar la clave privada del destinatario
            $privateKey = openssl_pkey_get_private(file_get_contents('private.key'));

            // Verificar que se cargó la clave privada
            if (!$privateKey) {
                die("Error al cargar la clave privada");
            }

            // Consulta para recuperar todos los mensajes
            $sql = "SELECT nombre_contacto, numero_contacto, correo_contacto, comentario_contacto FROM contacto";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                while ($result = $stmt->fetch()) {
                    // Intenta descifrar los datos recuperados
                    if (openssl_private_decrypt($result['comentario_contacto'], $comentario_descifrado, $privateKey)) {
                        // Descifrado exitoso, muestra el comentario
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo "<strong>Nombre de contacto:</strong> " . $result['nombre_contacto'] . "<br>";
                        echo "<strong>Número de contacto:</strong> " . $result['numero_contacto'] . "<br>";
                        echo "<strong>Correo de contacto:</strong> " . $result['correo_contacto'] . "<br>";
                        echo "<strong>Comentario:</strong> " . $comentario_descifrado . "<br>";
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo "Error en el descifrado del comentario.";
                    }
                }
            } else {
                echo "No se encontraron datos.";
            }
            ?>
        </div>
    </div>

    <?php include('footer.html');?>
    
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
