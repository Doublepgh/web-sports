<?php
session_start();

if (isset($_POST['nombre']) && isset($_POST['precio'])) {
    $producto = [
        'nombre' => $_POST['nombre'],
        'precio' => $_POST['precio'],
    ];

    // Agrega el producto al carrito en la sesión
    $_SESSION['carrito'][] = $producto;

    echo 'Producto agregado al carrito';
} else {
    echo 'Error al agregar el producto al carrito';
}
?>
