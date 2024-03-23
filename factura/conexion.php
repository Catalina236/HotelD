<?php
// Establecer la conexión a la base de datos
// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root"; // Reemplaza con tu nombre de usuario
$password = ""; // Reemplaza con tu contraseña
$database = "base_proyecto"; // Reemplaza con el nombre de tu base de datos

//lista de tablas
$factura = "factura";
$reserva = "reserva";
$persona = "persona";
$usuario = "usuario";
$carrito_persona = "carrito_persona";
$detalle_factura = "detalle_factura";
$servicios_adicionales = "servicios_adicionales";
$restaurante = "restaurante";
$bar = "bar";
$zonas_humedas = "zonas_humedas";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Después de conectar a la base de datos, establece el conjunto de caracteres UTF-8
$conn->set_charset("utf8");
