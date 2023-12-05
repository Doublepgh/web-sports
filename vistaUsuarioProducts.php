
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario Home</title>
    <link rel="stylesheet" href="style/admin.css">
    <style>
    .card img {
        width: 300px; /* ajusta el tamaño según tus preferencias */
        height: 250px; /* ajusta el tamaño según tus preferencias */
        object-fit: cover; /* mantiene la proporción y corta la imagen si es necesario */
    }
</style>
</head>
<body>

<?php include 'header.html';?>
  
<nav>
    <a href="vistaUsuarioProducts.php">Inicio</a>
    <a href="VistaCarrito.php">Mis compras</a>
    <a href="mensajesUser.php">Mensajes</a>
    <a href="#" onclick="cerrarSesion()">Cerrar Sesión</a>
</nav>

<section>
    <h2 align="center">Productos Disponibles</h2>

    <div class="product-container">
        <div class="card">
            <img src="https://imgs.search.brave.com/z9qeVg0lvsZlzV_5UU71ynwyFcJHxHVIpYe1T23KV1E/rs:fit:860:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5nZXR0eWltYWdl/cy5jb20vaWQvNDU4/MDY4MDk3L3Bob3Rv/L2FkaWRhcy1zdXBl/cnN0YXIuanBnP3M9/NjEyeDYxMiZ3PTAm/az0yMCZjPWNCVFNk/dWs1X3BQSGRRaS1R/el9ZZ0pya2NlSE00/V2s0b0R3dzVPX3Z3/YXc9" alt="Producto 1">
            <div class="card-body">
                <h3>Tenis Adidas R6</h3>
                <p>Precio: $1495.99</p>
                <p>calzado</p>
             
                <button class="add-to-cart-btn" onclick="agregarAlCarrito('Tenis Adidas R6', 1495.99)">Agregar al carrito</button>
            </div>
        </div>

        <div class="card">
            <img src="https://imgs.search.brave.com/3VU8AUbhdpgdrn8oyligpysCMcNvdbCrQJuNmfx0kVw/rs:fit:860:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5nZXR0eWltYWdl/cy5jb20vaWQvNDU5/MjI3NzQ1L2ZyL3Bo/b3RvL2xhLWZlbiVD/MyVBQXRyZS1kZS1t/YWdhc2luLWRlLWNo/YXVzc3VyZXMtYWRp/ZGFzLmpwZz9zPTYx/Mng2MTImdz0wJms9/MjAmYz01Q0xXdkxj/YVRac09kT2VjMFh3/YkdMNVR1czUwYjdN/eUZfQWNNUzJEZzlB/PQ" alt="Producto 2">
            <div class="card-body">
                <h3>Tenis Runfalcon 3</h3>
                <p>Precio: $1195.20</p>
                <p>calzado</p>
                <button class="add-to-cart-btn" onclick="agregarAlCarrito('Tenis Runfalcon', 1195.20)">Agregar al carrito</button>
            </div>
        </div>

        <div class="card">
            <img src="https://imgs.search.brave.com/G-1tYDYEp6i4sLiGZm_Mqa1mLapBaNq2ofo0vonhuzg/rs:fit:860:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NTE2ckZNd0Vkckwu/anBn" alt="Producto 3">
            <div class="card-body">
                <h3>Zandalias Adidas</h3>
                <p>Precio: $520.55</p>
                <p>calzado</p>
                <button class="add-to-cart-btn" onclick="agregarAlCarrito('Zandalias Adidas', 520.55)">Agregar al carrito</button>
            </div>
        </div>
        <div class="card">
            <img src="https://imgs.search.brave.com/6uhA0VFaAojyNrEHfa3RPKhYFFBks8ZCLDdN2xaNfDA/rs:fit:860:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NjF6aFN5OEFJUEwu/anBn" alt="Producto 3">
            <div class="card-body">
            <h3>Tenis Hoops 3.0</h3>
                <p>Precio: $1850.20</p>
                <p>calzado</p>
                <button class="add-to-cart-btn" onclick="agregarAlCarrito('Tenis Hoops 3.0', 1850.20)">Agregar al carrito</button>
            </div>
        </div>
        <div class="card">
            <img src="https://imgs.search.brave.com/aMy32USOohd1MEUVdCa8xbnpRVr03xwj6THL6b8kA30/rs:fit:860:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NTFOTjhJSStmbUwu/anBn" alt="Producto 3">
            <div class="card-body">
            <h3>Playera Nike</h3>
                <p>Precio: $770.99</p>
                <p>Ropa</p>
                <button class="add-to-cart-btn" onclick="agregarAlCarrito('Playera Nike', 770.99)">Agregar al carrito</button>
            </div>
        </div>
        <div class="card">
            <img src="https://imgs.search.brave.com/S6egtM0jMwL2NJZWVy0A7RoStxGXqlb6aWYjxPV38mQ/rs:fit:860:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NDFaeHhLelJ1c0wu/anBn" alt="Producto 3">
            <div class="card-body">
            <h3>Playera Deportiva</h3>
                <p>Precio: $890.99</p>
                <p>Ropa</p>
                <button class="add-to-cart-btn" onclick="agregarAlCarrito('Playera Deportiva', 890.99)">Agregar al carrito</button>
            </div>
        </div>
        <div class="card">
            <img src="https://imgs.search.brave.com/YvG-2R01ykR18hjWH7nelC96WJwB2cobbETJUYPt5ds/rs:fit:860:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NTFlWFR2Wkw2d1Mu/anBn" alt="Producto 3">
            <div class="card-body">
                <h3>Pants Puma Rx</h3>
                <p>Precio: $650.99</p>
                <p>Ropa</p>
                <button class="add-to-cart-btn" onclick="agregarAlCarrito('Pants Puma Rx', 650.99)">Agregar al carrito</button>
            </div>
        </div>
        <div class="card">
            <img src="images/messi.webp" alt="Producto 3">
            <div class="card-body">
            <h3>Chamarra AEROREADY</h3>
                <p>Precio: $1250.99</p>
                <p>Ropa</p>
                <button class="add-to-cart-btn" onclick="agregarAlCarrito('Chamarra AEROREADY', 1250.99)">Agregar al carrito</button>
            </div>
        </div>
    </div>
</section>

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

    function agregarAlCarrito(nombre, precio) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'agregar_al_carrito.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Muestra una alerta al usuario
                alert(xhr.responseText);
            }
        };
        xhr.send('nombre=' + encodeURIComponent(nombre) + '&precio=' + encodeURIComponent(precio));
    }
</script>

</body>
</html>
