<?php
require '../Bd/conexion.php';
$conn=conectar_db();
$code=$_GET['cod_reserva'];
$code=filter_var($code, FILTER_SANITIZE_NUMBER_INT);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "DELETE FROM reserva WHERE cod_reserva = '$code'";

if ($conn->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('Reserva cancelada exitosamente');
    window.location='ver_reservas.php';
    </script>";
} else {
    echo "Error al cancelar reserva: " . $conn->error;
}

$conn->close();
?>