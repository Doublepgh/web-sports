<?php
$tipoUsuario = "Usuario";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
    <link rel="stylesheet" href="style/adminInicio.css">
    
</head>
<body>
    <div class="container">
        <?php include 'header.html';?>
        <nav>
            <a href="vistaUsuarioProducts.php">Inicio</a>
            <a href="mensajesUser.php">Mensajes</a>
            <a href="#" onclick="cerrarSesion()">Cerrar Sesión</a>
        </nav>

        <div>
            <?php
            require 'database.php';

            // Consulta para recuperar todos los mensajes
            $sql = "SELECT nombre_contacto, numero_contacto, correo_contacto, comentario_contacto FROM contacto";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                while ($result = $stmt->fetch()) {
                    // Limita la longitud del comentario a 10 caracteres
                    $comentario_corto = substr($result['comentario_contacto'], 0, 10);

                    // Muestra los mensajes cifrados y limitados a 10 caracteres
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo "<strong>Nombre de contacto:</strong> " . $result['nombre_contacto'] . "<br>";
                    echo "<strong>Número de contacto:</strong> " . $result['numero_contacto'] . "<br>";
                    echo "<strong>Correo de contacto:</strong> " . $result['correo_contacto'] . "<br>";
                    $privateKey = openssl_pkey_get_private(file_get_contents('private.key'));
                    openssl_private_decrypt($result['comentario_contacto'], $comentario_descifrado, $privateKey);

                    // Agregar un icono y un contenedor para el comentario cifrado
                    echo '<strong>Comentario cifrado: </strong>';
                    echo '<span id="comentarioCifrado">' . $comentario_corto . '</span>';
                    echo '<button onclick="toggleComentario()">Mostrar/ocultar</button>';

                    // Agregar un contenedor para el comentario descifrado
                    echo '<div id="comentarioDescifrado" style="display:none;">';
                    echo '<strong>Comentario descifrado: </strong>' . $comentario_descifrado;
                    echo '</div>';
                    // echo "<strong>Comentario cifrado </strong> " . $comentario_corto . "<br>";
                    echo '</div>';
                    echo '</div>';
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

<script>
  function toggleComentario() {
    var cardBody = button.parentNode;
    var comentarioCifradoElement = document.getElementById('comentarioCifrado');
    var comentarioDescifradoElement = document.getElementById('comentarioDescifrado');

    if (comentarioCifradoElement.style.display === 'none') {
      comentarioCifradoElement.style.display = 'inline';
      comentarioDescifradoElement.style.display = 'none';
    } else {
      comentarioCifradoElement.style.display = 'none';
      comentarioDescifradoElement.style.display = 'inline';
    }
  }
</script>

    <?php include('footer.html');?>
</body>
</html>
