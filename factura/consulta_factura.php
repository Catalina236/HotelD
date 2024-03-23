<?php
header('Content-Type: text/html; charset=utf-8');
require_once("../Bd/conexion.php");

// Verificar si hay una sesión iniciada
session_start();

$conn = conectar_db();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['correo_electronico'])) {
    die("No hay un usuario logeado.");
}

// Obtener el ID del usuario logeado
$user_id = $_SESSION['correo_electronico'];

// Consulta SQL para obtener los detalles de la factura del usuario logeado
$sql = "SELECT 
    factura.cod_factura,
    factura.fecha_factura,
    factura.metodo_pago,
    reserva.cod_reserva,
    reserva.fecha_inicio,
    reserva.fecha_fin,
    reserva.precio,
    persona.nombres,
    persona.apellidos,
    detalle_factura.cod_det_factura,
    carrito_persona.cod_carrito,
    carrito_persona.id_agregadosrest,
    carrito_persona.id_agregadosbar,
    carrito_persona.id_agregadoszonas,
    carrito_persona.cantidad,
    carrito_persona.subtotal,
    tipo_habitacion.nom_tipo_hab,
    tipo_habitacion.valor_base,
    DATEDIFF(reserva.fecha_fin, reserva.fecha_inicio) AS dias_reserva
FROM
    factura
        INNER JOIN
    reserva ON factura.cod_reserva = reserva.cod_reserva
        INNER JOIN
    persona ON factura.num_doc = persona.num_doc
        INNER JOIN
    detalle_factura ON factura.cod_factura = detalle_factura.cod_factura
        INNER JOIN
    carrito_persona ON detalle_factura.cod_carrito = carrito_persona.cod_carrito
        INNER JOIN
    tipo_habitacion ON reserva.cod_tipo_hab = tipo_habitacion.cod_tipo_hab
WHERE
    persona.correo_electronico = '$user_id'";

$result = $conn->query($sql);

if ($result === false) {
    die("Error en la consulta: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Obtener la primera fila de resultados
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Factura Electrónica</title>
        <link rel="stylesheet" href="../factura/style.css">
    </head>
    <body>

    <div class="factura-container">
        <div class="header">
            <h2>Factura Electrónica</h2>
            <p>Fecha: <?php echo date("d/m/Y"); ?></p>
        </div>
        
        <div class="info-cliente">
            <h3>Información del Cliente</h3>
            <p>Nombre: <?php echo $row["nombres"] . " " . $row["apellidos"]; ?></p>
        </div>
        

        <div class="detalle-factura">
            <h3>Detalle de la Reserva</h3>
            <!-- Aquí va el código para la tabla de detalle de reserva -->
        </div>
        
        <div class="detalle-factura">
            <h3>Detalle del Carrito</h3>
            <!-- Aquí va el código para la tabla de detalle del carrito -->
        </div>
        
        <div class="total">
            <h3>Total FACTURA: $<?php echo $row["subtotal"] + $row["valor_base"] * $row['dias_reserva']; ?></h3>
        </div>
        <form action="generar_pdf.php" method="POST">
            <input type="hidden" name="cod_factura" value="<?php echo $row["cod_factura"]; ?>">
            <button type="submit">Descargar Factura en PDF</button>
        </form>
    </div>

    </body>
    </html>

<?php
} else {
    echo "No se encontraron detalles de factura.";
}

// Cerrar conexión
$conn->close();
?>
