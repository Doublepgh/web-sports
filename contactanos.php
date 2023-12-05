<?php
require 'database.php';

$messageExito = $messageError = '';

$publicKey = openssl_pkey_get_public(file_get_contents('public.key'));

$nombre_contacto = $numero_contacto = $correo_contacto = $comentario_contacto = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	if(!empty($_POST['numero_contacto']) && preg_match('/^\d{10}$/', $_POST['numero_contacto'])){
		$nombre_contacto = filter_input(INPUT_POST, 'nombre_contacto', FILTER_SANITIZE_STRING);
		$numero_contacto = filter_input(INPUT_POST, 'numero_contacto', FILTER_SANITIZE_STRING);
		$correo_contacto = filter_input(INPUT_POST, 'correo_contacto', FILTER_SANITIZE_EMAIL);
		$comentario_contacto = filter_input(INPUT_POST, 'comentario_contacto', FILTER_SANITIZE_STRING);

		openssl_public_encrypt($comentario_contacto, $comentario_cifrado, $publicKey);

		$sql = "INSERT INTO contacto (nombre_contacto, numero_contacto, correo_contacto, comentario_contacto) VALUES (:nombre_contacto, :numero_contacto, :correo_contacto, :comentario_contacto)";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':nombre_contacto', $nombre_contacto, PDO::PARAM_STR);
		$stmt->bindParam(':numero_contacto', $numero_contacto, PDO::PARAM_STR);
		$stmt->bindParam(':correo_contacto', $correo_contacto, PDO::PARAM_STR);

		$stmt->bindParam(':comentario_contacto', $comentario_cifrado, PDO::PARAM_LOB);

		try{
			if ($stmt->execute()) {
				$messageExito = 'Mensaje enviado correctamente';
				$nombre_contacto = $numero_contacto = $correo_contacto = $comentario_contacto = '';
			} else {
				$messageError = 'Ha ocurrido un error enviando su mensaje';
			}
			} catch (PDOException $e) {
				$messagError = 'Error de base de datos: ' . $e->getMessage();
			}
	} else {
		$messageError = 'El campo de teléfono debe contener 10 dígitos numéricos.';
	}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="style/adminInicio.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

        <?php include 'header2.html';?>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="login.php">Login</a>
        <a href="register.php">Registrar</a>
        <a href="contactanos.php">Contactanos</a>
    </nav>
  
    <?php require 'partials/headerlogin.php'?>
    <center>
	<?php if (!empty($messageExito) || !empty($messageError)): ?>
            <script type="text/javascript">
                <?php if (!empty($messageExito)): ?>
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "<?php echo $messageExito; ?>",
                    }).then(function() {
                            document.getElementById('nombre_contacto').value = '';
                            document.getElementById('numero_contacto').value = '';
                            document.getElementById('correo_contacto').value = '';
                            document.getElementById('comentario_contacto').value = '';
                    });
                <?php elseif (!empty($messageError)): ?>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "<?php echo $messageError; ?>",
                    });
                <?php endif; ?>
            </script>
        <?php endif; ?>
</center>
<h2 align="center"> Contactanos</h2>
	<center>
	<span><a href="login.php">Login </a> </span>
	<span> o <a href="register.php">Registro</a> </span>
<form id="contactoForm" action="contactanos.php" method="POST">
	</center>
	<div class="form-container">
		<div class="input-container">
			<input type="text" id="nombre_contacto" name="nombre_contacto" placeholder="Ingresa tu nombre" required maxlength="30" value="<?= isset($_POST['nombre_contacto']) ? htmlspecialchars($_POST['nombre_contacto']) : '' ?>">
			<br><span id="errorNombre" class="error-message"></span>
		</div>
		<div class="input-container">
			<input type="text"id="numero_contacto" name="numero_contacto" placeholder="Ingresa tu numero de telefono" required maxlength="10" value="<?= isset($_POST['numero_contacto']) ? htmlspecialchars($_POST['numero_contacto']) : '' ?>">
			<br><span id="errorNumero" class="error-message"></span>
		</div>
		<div class="input-container">
			<input type="text" id="correo_contacto" name="correo_contacto" placeholder="Ingresa tu correo electronico"required maxlength="30" value="<?= isset($_POST['correo_contacto']) ? htmlspecialchars($_POST['correo_contacto']) : '' ?>">
			<br><span id="errorCorreo" class="error-message"></span>
		</div>
		<div class="input-container">
			Mensaje: <input type="text" id="comentario_contacto" name="comentario_contacto" required maxlength="100" value="<?= isset($_POST['comentario_contacto']) ? htmlspecialchars($_POST['comentario_contacto']) : '' ?>">
			<br><span id="errorComentario" class="error-message"></span>
		</div>
</div>
<div class="button-container" align="left">
<input type="submit" value="Enviar" class="boton" style="width: 70px;" align="left">
</div>
<br><br>

    <footer>
        © 2023 Tienda de Deportes en Línea
    </footer>

	<style>
    .error-message {
        color: red;
        margin-top: 1px;
    }
</style>

	<script>
    document.addEventListener('DOMContentLoaded', function () {
        function validarCampo(input, errorContainer, regex) {
            var inputValue = input.value;

            if (!regex.test(inputValue)) {
                input.style.border = '2px solid red';
                errorContainer.innerHTML = 'Este campo no cumple con el formato requerido.';
                errorContainer.style.color = 'red';
                errorContainer.style.display = 'block';
                input.setCustomValidity('Invalid');
            } else {
                input.style.border = '1px solid #ccc';
                errorContainer.innerHTML = '';
                errorContainer.style.display = 'none';
                input.setCustomValidity('');
            }
        }

        // Asociar la función de validación al campo de usuario
        var nombreInput = document.getElementById('nombre_contacto');
        var errorNombreContainer = document.getElementById('errorNombre');
        var regexNombre = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/;

        nombreInput.addEventListener('input', function () {
            validarCampo(nombreInput, errorNombreContainer, regexNombre);
        });

        // Asociar la función de validación al campo de número de teléfono
        var numeroInput = document.getElementById('numero_contacto');
        var errorNumeroContainer = document.getElementById('errorNumero');
        var regexNumero = /^\d+$/;

        numeroInput.addEventListener('input', function () {
            validarCampo2(numeroInput, errorNumeroContainer, regexNumero);
        });
        function validarNumero() {
            validarCampo2(numeroInput, errorNumeroContainer, regexNumero, function (valor) {
                // Verificar si el número de teléfono tiene 10 dígitos
                return valor.length === 10;
            });
        }
        // Función de validación genérica para campos
        function validarCampo2(input, errorContainer, regex, customValidation) {
            var valor = input.value.trim();
            if (regex.test(valor) && (customValidation ? customValidation(valor) : true)) {
                errorContainer.innerHTML = '';
                return true;
            } else {
                errorContainer.innerHTML = 'Ingrese 10 dígitos.';
                return false;
            }
        }

        //Asociar la funcion para el campo correo
        var correoInput = document.getElementById('correo_contacto');
        var errorCorreoContainer = document.getElementById('errorCorreo');
        var regexCorreo = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        correoInput.addEventListener('input', function (){
            validarCampo(correoInput, errorCorreoContainer, regexCorreo);
        })

		//Asociar la funcion de validación al campo de comentario
        var comentarioInput = document.getElementById('comentario_contacto');
        var errorComentarioContainer = document.getElementById('errorComentario');
        var regexComentario = /^[a-zA-Z0-9., ]+$/;

        comentarioInput.addEventListener('input', function () {
            validarCampo(comentarioInput, errorComentarioContainer, regexComentario);
        })
    });
</script>
</body>
</html>
