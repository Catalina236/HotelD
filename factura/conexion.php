<?php
// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root"; // Reemplaza con tu nombre de usuario
$password = ""; // Reemplaza con tu contraseña
$database = "base_proyecto"; // Reemplaza con el nombre de tu base de datos

//lista de tablas
$factura = "factura";
$reserva = "reserva";
$persona = "persona";
$carrito_persona = "carrito_persona";
$detalle_factura = "detalle_factura";
$servicios_adicionales = "servicios_adicionales";


// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);



// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else{echo('');}
