<?php 

session_start();

require 'database.php';
try {
    if (!empty($_POST['usuario']) && !empty($_POST['password'])) {
        $usuario = filter_input(INPUT_POST, 'usuario');

        if (!preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/', $usuario)) {
            $message = "El nombre de usuario no es válido.";
        } else {
            $records = $conn->prepare('SELECT id, usuario, contrasenia FROM users WHERE usuario = :usuario');
            $records->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);
        
        
            $messages = "";
            $ip = $_SERVER['REMOTE_ADDR'];
            $captcha = $_POST['g-recaptcha-response'];
            $secretkey = "6Lf3xhwpAAAAAPZn6WLRANbTdnzexbJB4PmuOlWy";
        
            $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
        
            $atributos = json_decode($respuesta,TRUE);
        
            if(!$atributos['success']){
                $messages = "El campo del recaptcha es obligatorio";
            }
        
            $message = "";
            if ($results && password_verify($_POST['password'], $results['contrasenia'])&&$atributos['success']) {
                $_SESSION['user_id'] = $results['id'];
                if ($usuario === "admin_secure123" && $_POST['password'] === "jose*10") {
                    header('location: /sportss/vistaAdminInicio.php'); // Redirige al administrador a su vista con mensajes descifrados
                } else {
                    header('location: /sportss/vistaUsuarioProducts.php'); // Redirige a los usuarios a su vista con mensajes cifrados
                }
            } else {
                $message = "Lo siento, tus credenciales no coinciden o te falto el recaptcha.";
            }
        }
    }
} catch (PDOException $e) {
    echo "Error de base de datos: " . $e->getMessage();
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/adminInicio.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        #logo {
            max-width: 50px; /* Ajusta el tamaño de la imagen según tu preferencia */
            margin-right: 10px; /* Ajusta el margen entre la imagen y el título */
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
  
    <?php 
	require 'partials/headerlogin.php'
    ?>
<div class="container">
    <center>
        <img src="images/user.png" alt="" id="logo">
<h4>INICIO DE SESIÓN</h4>

<span>¿Aún no tienes una cuenta? <a href="register.php"> Registrate</a> </span>
</center>
</div>
<?php if(!empty($message)): ?>
        <?php
        echo '<script type="text/javascript">';
        echo 'Swal.fire({
                icon: "error",
                title: "Error",
                text: "' . $message . '",
            })';
        echo '</script>';
        ?>
		<?php
		endif;
?>

	<form action="login.php" method="POST">
        <div class="form-container">
            <input type="text" name="usuario" placeholder="ingresa tu usuario" requiered required maxlength="15">
            <input type="password" name="password" placeholder="ingresa tu contraseña" required required maxlength="15">
            <div class = "g-recaptcha" data-sitekey = "6Lf3xhwpAAAAAADBMfyzZLMg294r2aOKMpIA9QD6"></div>
        </div>
        <br>
        <div class="button-container">
            <input type="submit" value="Enviar" class="boton" style="width: 70px; height: 35px">
        </div>
        <div>
            
        </div>
	</form>

    <footer>
        © 2023 Tienda de Deportes en Línea
    </footer>
</body>
</html>
