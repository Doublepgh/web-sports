<?php
session_start();
require 'database.php';

// Función para calcular el total de la compra
function calcularTotalCompra() {
    $total = 0;
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $producto) {
            $total += $producto['precio'];
        }
    }
    return $total;
}

// Función para eliminar un producto del carrito
function eliminarProducto($indice) {
    if (isset($_SESSION['carrito'][$indice])) {
        unset($_SESSION['carrito'][$indice]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reorganiza los índices
    }
}

// Manejar la eliminación de productos si se proporciona un índice
if (isset($_GET['eliminar'])) {
    eliminarProducto($_GET['eliminar']);
}

$messageExito = $messageError = '';

if (!empty($_POST['nombre']) && !empty($_POST['tarjeta']) && !empty($_POST['fecha_caducidad']) && !empty($_POST['cvv'])) {
    if(!empty($_POST['tarjeta']) && preg_match('/^\d{16}$/', $_POST['tarjeta']) && !empty($_POST['cvv']) && preg_match('/^\d{3}$/', $_POST['cvv'])){
        $sql = "INSERT INTO compras (titular_targeta,numero_targeta,fecha_expiracion,cvv,total_compra) 
            VALUES (:titular_targeta,:numero_targeta,:fecha_expiracion,:cvv,:total_compra)";

        $stmt = $conn->prepare($sql);
        
        // Validar y limpiar las entradas del usuario
    
        $titular_targeta = filter_input(INPUT_POST, 'nombre');
        $numero_targeta = password_hash($_POST['tarjeta'], PASSWORD_BCRYPT);
        $fecha_caducidad = password_hash($_POST['fecha_caducidad'], PASSWORD_BCRYPT);
        $cvv = password_hash($_POST['cvv'], PASSWORD_BCRYPT);
        $total_compra = calcularTotalCompra();

        $stmt->bindParam(':titular_targeta', $titular_targeta, PDO::PARAM_STR);
        $stmt->bindParam(':numero_targeta', $numero_targeta, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_expiracion', $fecha_caducidad, PDO::PARAM_STR);
        $stmt->bindParam(':cvv', $cvv, PDO::PARAM_STR);
        $stmt->bindParam(':total_compra', $total_compra, PDO::PARAM_STR);

        try {
            if ($stmt->execute()) {
                // Eliminar productos del carrito después de realizar el pago
                $_SESSION['carrito'] = array();
                $messageExito = 'Pago realizado correctamente';
            } else {
                $messageError = 'Ha ocurrido un error en el pago';
            }
        } catch (PDOException $e) {
            $messageError = 'Error de base de datos: ' . $e->getMessage();
        }
    } else {
        $messageError = 'El numero de tarjeta debe contener 16 dígitos numéricos.';
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="style/admin.css">
    <link rel="stylesheet" href="style/pasarela.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%; /* Cambia este valor según tus preferencias */
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .payment-message {
            display: none; /* Ocultar el mensaje por defecto */
        }

        .modal .payment-message {
            display: block; /* Mostrar el mensaje dentro del modal */
        }

    </style>

    
</head>
<body>

<?php include 'header.html';?>
  
<nav>
    <a href="vistaUsuarioProducts.php">Inicio</a>
    <a href="VistaCarrito.php">Mis compras</a>
    <a href="mensajesUser.php">Mensajes</a>
    <a href="logout.php" onclick="cerrarSesion()">Cerrar Sesión</a>
</nav>

<h2>Mis compras</h2>
<center>
<?php if (!empty($messageExito) || !empty($messageError)): ?>
            <script type="text/javascript">
                <?php if (!empty($messageExito)): ?>
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "<?php echo $messageExito; ?>",
                    }).then(function() {
                        document.getElementById('nombre').value = '';
                        document.getElementById('tarjeta').value = '';
                        document.getElementById('fecha_caducidad').value = '';
                        document.getElementById('cvv').value = '';
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

<!-- Mostrar el mensaje solo dentro del modal -->
<div class="modal" id="paymentModal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="payment-message <?= !empty($message) ? 'success' : 'error'; ?>">
            <p><?= $message ?></p>
        </div>
    </div>
</div>

<center>
<?php
// Validar si hay productos en el carrito
if (empty($_SESSION['carrito'])) {
    echo '<p>No hay productos en el carrito</p>';
} else {
?>
</center>


<form id="carritoForm" action="VistaCarrito.php" method="POST">
    <?php
    $totalCompra = calcularTotalCompra();
    
    foreach ($_SESSION['carrito'] as $indice => $producto) {
        echo '<p>' . $producto['nombre'] . ' - $' . $producto['precio'] . ' <a href="?eliminar=' . $indice . '">Eliminar</a></p>';
    }
    echo '<p>Total de compra: $' . $totalCompra . '</p>';
    ?>

    <h3>Información de Pago</h3>
    <div class="form-container">
        <div class="input-container">
            <label for="nombre">Nombre del Titular:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required maxlength="50" value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '' ?>">
            <br><span id="errorNombre" class="error-message"></span>
        </div>
        <div class="input-container">
            <label for="tarjeta">Número de Tarjeta:</label>
            <input type="text" id="tarjeta" name="tarjeta" placeholder="Ingresa tu número de tarjeta" required maxlength="16" value="<?= isset($_POST['tarjeta']) ? htmlspecialchars($_POST['tarjeta']) : '' ?>">
            <br><span id="errorTarjeta" class="error-message"></span>
        </div>
        <div class="input-container">
            <label for="fecha_caducidad">Fecha de Caducidad (MM/AA):</label>
            <input type="text" id="fecha_caducidad" name="fecha_caducidad" placeholder="MM/AA" required maxlength="4" value="<?= isset($_POST['fecha_caducidad']) ? htmlspecialchars($_POST['fecha_caducidad']) : '' ?>">
            <br><span id="errorCaducidad" class="error-message"></span>
        </div>
        <div class="input-container">
            <label for="cvv">CVV:</label>
            <input type="password" id="cvv" name="cvv" placeholder="CVV" required maxlength="3" value="<?= isset($_POST['cvv']) ? htmlspecialchars($_POST['cvv']) : '' ?>">
            <br><span id="errorCvv" class="error-message"></span>
        </div>
    </div>
    <input type="submit" value="Pagar">
</form>

<?php
}
?>

<script>
    function cerrarSesion() {
        document.getElementById('formCerrarSesion').submit();
    }
    
</script>
<script>
    // Mostrar el modal al cargar la página si hay un mensaje
    window.onload = function() {
        <?php if (!empty($message)) : ?>
            showModal();
        <?php endif; ?>
    };

    // Funciones para mostrar y cerrar el modal
    function showModal() {
        document.getElementById('paymentModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('paymentModal').style.display = 'none';
    }
</script>

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

        // Asociar la función de validación al campo de nombre
        var nombreInput = document.getElementById('nombre');
        var errorNombreContainer = document.getElementById('errorNombre');
        var regexNombre = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/;

        nombreInput.addEventListener('input', function () {
            validarCampo(nombreInput, errorNombreContainer, regexNombre);
        });

        // Asociar la función de validación al campo tarjeta
        var tarjetaInput = document.getElementById('tarjeta');
        var errorTarjetaContainer = document.getElementById('errorTarjeta');
        var regexTarjeta = /^\d+$/;

        tarjetaInput.addEventListener('input', function () {
            validarCampo2(tarjetaInput, errorTarjetaContainer, regexTarjeta, 'Ingrese 16 dígitos');
        });
        function validarTelefono() {
            validarCampo2(tarjetaInput, errorTarjetaContainer, regexTarjeta, function (valor) {
                return valor.length === 16;
                
            });
        }
        // Asociar la función de validación al campo Fecha de caducidad
        var caducidadInput = document.getElementById('fecha_caducidad');
        var errorCaducidadContainer = document.getElementById('errorCaducidad');
        var regexCaducidad = /^\d+$/;

        caducidadInput.addEventListener('input', function () {
            validarCampo2(caducidadInput, errorCaducidadContainer, regexCaducidad, 'Ingrese 4 dígitos');
        });
        function validarCaducidad() {
            validarCampo2(caducidadInput, errorCaducidadContainer, regexCaducidad, function (valor) {
                return valor.length === 4;
                
            });
        }
        // Asociar la función de validación al campo CVV
        var cvvInput = document.getElementById('cvv');
        var errorCvvContainer = document.getElementById('errorCvv');
        var regexCvv = /^\d+$/;

        cvvInput.addEventListener('input', function () {
            validarCampo2(cvvInput, errorCvvContainer, regexCvv, 'Ingrese 3 dígitos');
        });
        function validarCvv() {
            validarCampo2(cvvInput, errorCvvContainer, regexCvv, function (valor) {
                return valor.length === 3;
                
            });
        }

        // Función de validación genérica para campos
        function validarCampo2(input, errorContainer, regex,mensaje,customValidation) {
            var valor = input.value.trim();

            if (regex.test(valor) && (customValidation ? customValidation(valor) : true)) {
                errorContainer.innerHTML = '';
                return true;
            } else {
                errorContainer.innerHTML = mensaje;
                return false;
            }
        }
    });
    </script>
<footer>
    © 2023 Tienda de Deportes en Línea
</footer>
</body>
</html>
