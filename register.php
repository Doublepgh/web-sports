<?php
require 'database.php';

$messageExito = $messageError = '';

if (!empty($_POST['usuario']) && !empty($_POST['password'])) {

    if (!empty($_POST['telefono']) && preg_match('/^\d{10}$/', $_POST['telefono'])){
            $sql = "INSERT INTO users (usuario, contrasenia, numero_telefono, correo) 
                VALUES (:usuario, :contrasenia, :numero_telefono, :correo)";

        $stmt = $conn->prepare($sql);
        
        $usuario = filter_input(INPUT_POST, 'usuario');
        $contrasenia = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $numero_telefono = filter_input(INPUT_POST, 'telefono');
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);

        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':contrasenia', $contrasenia, PDO::PARAM_STR);
        $stmt->bindParam(':numero_telefono', $numero_telefono, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);

        try {
        if ($stmt->execute()) {
            $messageExito = 'Usuario creado exitosamente';
            $usuario = $contrasenia = $numero_telefono = $correo = '';
        } else {
            $messageError = 'Ha ocurrido un error creando el usuario';
        }
        } catch (PDOException $e){
        $messageError = 'Error de base de datos: ' . $e->getMessage();
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
                        document.getElementById('usuario').value = '';
                        document.getElementById('password').value = '';
                        document.getElementById('telefono').value = '';
                        document.getElementById('correo').value = '';
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
<div>
<div class="container">
    <h2 align="center"> Registro</h2>
    <span> <center>¿Ya tienes una cuenta? <a href="login.php"> Iniciar Sesión</a> </center></span>

    <!-- Formulario con casilla de aceptar -->
    <form id="registroForm" action="register.php" method="POST">
        <div class="form-container">
            <div class="input-container">
                <input type="text" id="usuario" name="usuario" placeholder="Ingresa tu usuario" required maxlength="50" value="<?= isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : '' ?>">
                <br><span id="errorUsuario" class="error-message"></span>
            </div>
            <div class="input-container">
                <input type="text" id="password" name="password" placeholder="Ingresa tu contraseña" required maxlength="8" value="<?= isset($_POST['password']) ? htmlspecialchars($_POST['password']): '' ?>">
                <br><span id="errorPassword" class="error-message"></span>
            </div>
            <div class="input-container" id="telefono-section">
                <input type="text" id="telefono" name="telefono" placeholder="Ingresa tu número de teléfono" required maxlength="10" value="<?= isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : '' ?>">
                <br><span id="errorTelefono" class="error-message"></span>
            </div>
            <div class="input-container">
                <input type="text" id="correo" name="correo" placeholder="Agrega tu correo" required maxlength="100" value="<?= isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : '' ?>">
                <br><span id="errorCorreo" class="error-message"></span>
            </div>
            
        </div>
    <center>
            <!-- Casilla de aceptar términos -->
            <label>
                <input type="checkbox" name="aceptar_terminos" required>
                Acepto los <a href="avisop.html" target="_blank">Términos y Condiciones</a>.
            </label>
    </center>
      <br>
        <center>
            <div class="button-container">
                <input type="submit" value="Enviar" class="boton" style="width: 70px;">
            </div>
        </center>
    </form>
</div>

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
        var usuarioInput = document.getElementById('usuario');
        var errorUsuarioContainer = document.getElementById('errorUsuario');
        var regexUsuario = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/;

        usuarioInput.addEventListener('input', function () {
            validarCampo(usuarioInput, errorUsuarioContainer, regexUsuario);
        });

        // Asociar la función de validación al campo de número de teléfono
        var telefonoInput = document.getElementById('telefono');
        var errorTelefonoContainer = document.getElementById('errorTelefono');
        var regexTelefono = /^\d+$/;

        telefonoInput.addEventListener('input', function () {
            validarCampo2(telefonoInput, errorTelefonoContainer, regexTelefono);
        });
        function validarTelefono() {
            validarCampo2(telefonoInput, errorTelefonoContainer, regexTelefono, function (valor) {
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
        
        //Asociar la funcion de validación al campo de contrasenia
        var passwordInput = document.getElementById('password');
        var errorPasswordContainer = document.getElementById('errorPassword');
        var regexPassword = /^[a-zA-Z0-9.]+$/;

        passwordInput.addEventListener('input', function () {
            validarCampo(passwordInput, errorPasswordContainer, regexPassword);
        })

        //Asociar la funcion para el campo correo
        var correoInput = document.getElementById('correo');
        var errorCorreoContainer = document.getElementById('errorCorreo');
        var regexCorreo = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        correoInput.addEventListener('input', function (){
            validarCampo(correoInput, errorCorreoContainer, regexCorreo);
        })
    });
</script>
</body>
</html>
