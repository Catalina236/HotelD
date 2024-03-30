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
    bar.nom_producto_bar,
    bar.valor AS valor_bar,
    restaurante.nom_producto_rest,
    restaurante.valor AS valor_restaurante,
    zonas_humedas.nom_servicio_zh,
    zonas_humedas.valor AS valor_zonas_humedas,
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
        LEFT JOIN
    bar ON carrito_persona.id_agregadosbar = bar.id_bar
        LEFT JOIN
    restaurante ON carrito_persona.id_agregadosrest = restaurante.id_rest
        LEFT JOIN
    zonas_humedas ON carrito_persona.id_agregadoszonas = zonas_humedas.id_zon_hum
        INNER JOIN
    tipo_habitacion ON reserva.cod_tipo_hab = tipo_habitacion.cod_tipo_hab
WHERE
    persona.correo_electronico = '$user_id'";

$sql2= "SELECT
    SUM(restaurante.valor) AS total_restaurante,
    SUM(bar.valor) AS total_bar,
    SUM(zonas_humedas.valor) AS total_zonas_humedas
FROM
    carrito_persona
    INNER JOIN servicios_adicionales AS restaurante ON carrito_persona.id_agregadosrest = restaurante.id_producto
    INNER JOIN servicios_adicionales AS bar ON carrito_persona.id_agregadosbar = bar.id_producto
    INNER JOIN servicios_adicionales AS zonas_humedas ON carrito_persona.id_agregadoszonas = zonas_humedas.id_servicio
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
        <link rel="icon" href="../imagenes/logo.png">
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
            <table>
                <thead>
                    <tr>
                        <th>Código Reserva</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha fin</th>
                        <th>Tipo de Habitacion</th>
                        <th>Valor total de la reserva</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $row["cod_reserva"]; ?></td>
                        <td><?php echo $row["fecha_inicio"]; ?></td>
                        <td><?php echo $row["fecha_fin"]; ?></td>
                        <td><?php echo $row["nom_tipo_hab"]; ?></td>
                        <td><?php echo $row["valor_base"] * $row['dias_reserva']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="detalle-factura">
            <h3>Detalle del Carrito</h3>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Valor</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Restaurante</td>
                        <td><?php echo $row["nom_producto_rest"]; ?></td>
                        <td><?php echo $row["cantidad"]; ?></td>
                        <td><?php echo $row["valor_restaurante"]; ?></td>
                        <td><?php echo $row["cantidad"] * $row["valor_restaurante"]; ?></td>
                    </tr>
                    <tr>
                        <td>Bar</td>
                        <td><?php echo $row["nom_producto_bar"]; ?></td>
                        <td><?php echo $row["cantidad"]; ?></td>
                        <td><?php echo $row["valor_bar"]; ?></td>
                        <td><?php echo $row["cantidad"] * $row["valor_bar"]; ?></td>
                    </tr>
                    <tr>
                        <td>Zonas Húmedas</td>
                        <td><?php echo $row["nom_servicio_zh"]; ?></td>
                        <td><?php echo $row["cantidad"]; ?></td>
                        <td><?php echo $row["valor_zonas_humedas"]; ?></td>
                        <td><?php echo $row["cantidad"] * $row["valor_zonas_humedas"]; ?></td>
                    </tr>
                    <tr>
                        <td>Zonas Húmedas</td>
                        <td><?php echo $row["nom_servicio_zh"]; ?></td>
                        <td><?php echo $row["cantidad"]; ?></td>
                        <td><?php echo $row["valor_zonas_humedas"]; ?></td>
                        <td><?php echo $row["cantidad"] * $row["valor_zonas_humedas"]; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="total_servicios">
            <?php 
            $total_servicios_ads = $row["cantidad"] * $row["valor_restaurante"] + 
                       $row["cantidad"] * $row["valor_bar"] + 
                       $row["cantidad"] * $row["valor_zonas_humedas"];
            ?>
            <h2>Total SERVICIOS ADICIONALES: $<?php echo $total_servicios_ads; ?></h2>
        </div>
        
        <div class="total">
            <?php 
                $total_factura = $row["valor_base"] * $row['dias_reserva'] + $total_servicios_ads;
            ?>
            <h3>Total FACTURA: $<?php echo $total_factura; ?></h3>
        </div>
        
        <form action="generar_pdf.php" method="POST" target="_blank">
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



