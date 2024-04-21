<?php
// Establece el tipo de contenido y codificación de caracteres para la respuesta HTTP
//header('Content-Type: text/html; charset=utf-8');
// Incluye el archivo de conexión a la base de datos
require_once("../Bd/conexion.php");

// Inicia una sesión
session_start();

// Establece la conexión a la base de datos
$conn = conectar_db();

// Verifica si hay una sesión iniciada
if (!isset($_SESSION['correo_electronico'])) {
    // Termina la ejecución del script y muestra un mensaje si no hay un usuario logeado
    die("No hay un usuario logeado.");
}

// Obtiene el ID del usuario logeado
$user_id = $_SESSION['correo_electronico'];
$cod_reserva=$_GET['cod_reserva'];

// Consulta SQL para obtener las facturas del usuario logeado
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
    persona.num_doc,
    detalle_factura.cod_det_factura,
    carrito_persona.cod_carrito,
    carrito_persona.num_doc, -- Agregamos la columna num_doc a la selección
    carrito_persona.cod_servicio, -- Agregamos la columna cod_servicio a la selección
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
        LEFT JOIN
    reserva ON factura.cod_reserva = reserva.cod_reserva
        LEFT JOIN
    persona ON factura.num_doc = persona.num_doc
        LEFT JOIN
    detalle_factura ON factura.cod_factura = detalle_factura.cod_factura
        LEFT JOIN
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
    persona.correo_electronico = '$user_id' AND reserva.cod_reserva='$cod_reserva'";

// Ejecuta la consulta SQL
$result = $conn->query($sql);

// Verifica si hubo un error en la consulta
if ($result === false) {
    // Termina la ejecución del script y muestra el error generado por la consulta
    die("Error en la consulta: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="style.css">
    <title>Factura Electrónica</title>
</head>
<body>

<div class="factura-container">
    <div class="header">
        <h2>Factura Electrónica</h2>
        <p>Fecha: <?php echo date("d/m/Y"); ?></p>
    </div>
    
    <?php if ($result->num_rows > 0) : ?>
        <?php while ($row = $result->fetch_assoc()) : ?>
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
                            <td><?php echo isset($row["nom_tipo_hab"]) ? $row["nom_tipo_hab"] : ''; ?></td>
                            <td><?php echo $row["valor_base"] * $row['dias_reserva']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Agrega la sección de detalle del carrito -->
            <div class="detalle-factura">
            <?php
                        // Consulta SQL para obtener el contenido del carrito
                        $carrito_sql = "SELECT 
                            carrito_persona.*,
                            bar.nom_producto_bar AS nom_bar,
                            restaurante.nom_producto_rest AS nom_restaurante,
                            zonas_humedas.nom_servicio_zh AS nom_zonas_humedas
                            FROM carrito_persona
                            LEFT JOIN bar ON carrito_persona.id_agregadosbar = bar.id_bar
                            LEFT JOIN restaurante ON carrito_persona.id_agregadosrest = restaurante.id_rest
                            LEFT JOIN zonas_humedas ON carrito_persona.id_agregadoszonas = zonas_humedas.id_zon_hum
                            WHERE num_doc = '{$row['num_doc']}'";
                        $carrito_result = $conn->query($carrito_sql);

                        $total_servicios_ads = 0; // Inicializar el total de servicios adicionales
                            
                        if ($carrito_result->num_rows > 0) :
                            while ($carrito_row = $carrito_result->fetch_assoc()) :
                                // Sumar el subtotal al total de servicios adicionales
                                $total_servicios_ads += $carrito_row['subtotal'];
                        ?>
                        
                <h3>Detalle del Carrito</h3>
                <table class="tabla-carrito">
                    <thead>
                        <tr>
                            <th>ID Carrito</th>
                            <th>Número de Documento</th>
                            <th>Código de Servicio</th>
                            <th>Nombre del Producto</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                                <tr>
                                    <td><?= $carrito_row['cod_carrito'] ?></td>
                                    <td><?= $carrito_row['num_doc'] ?></td>
                                    <td><?= $carrito_row['cod_servicio'] ?></td>
                                    <td>
                                        <?php 
                                        if (!empty($carrito_row['nom_bar'])) {
                                            echo $carrito_row['nom_bar'];
                                        } elseif (!empty($carrito_row['nom_restaurante'])) {
                                            echo $carrito_row['nom_restaurante'];
                                        } elseif (!empty($carrito_row['nom_zonas_humedas'])) {
                                            echo $carrito_row['nom_zonas_humedas'];
                                        }
                                        ?>
                                    </td>
                                    <td><?= $carrito_row['cantidad'] ?></td>
                                    <td><?= $carrito_row['subtotal'] ?></td>
                                </tr>
                        <?php
                            endwhile;
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Fin de la sección de detalle del carrito -->

            <div class="total_servicios">
                <?php 

                if($total_servicios_ads){?>
                <!-- Mostrar el total de servicios adicionales -->
                <h2>Total SERVICIOS ADICIONALES: $<?php echo $total_servicios_ads; ?></h2>
                <?php }?>
            </div>
            
            <div class="total">
                <?php 
                    $total_factura = $row["valor_base"] * $row['dias_reserva'] + $total_servicios_ads;
                ?>
                <h3>Total FACTURA: $<?php echo $total_factura; ?></h3>
            </div>
            
            <!-- Formulario para descargar la factura en PDF -->
                <center><button type="submit"><a target="_blank" href="generar_pdf.php?cod_factura=<?php echo $row['cod_factura'];?>">Descargar Factura en PDF</a></button></center>
        <?php endwhile; ?>
    <?php else : ?>
        <!-- Muestra un mensaje si no se encontraron detalles de factura -->
        <p>No se encontraron detalles de factura.</p>
    <?php endif; ?>

</div>

</body>
</html>

<?php
// Cierra la conexión a la base de datos
$conn->close();
?>