<?php
// Incluye la clase FPDF
require_once('fpdf/fpdf.php');
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
$cod_factura=$_GET['cod_factura'];

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
    persona.correo_electronico = '$user_id' AND factura.cod_factura='$cod_factura'";

// Ejecuta la consulta SQL
$result = $conn->query($sql);

// Verifica si hubo un error en la consulta
if ($result === false) {
    // Termina la ejecución del script y muestra el error generado por la consulta
    die("Error en la consulta: " . $conn->error);
}

// Verifica si se encontraron filas en el resultado de la consulta
if ($result->num_rows > 0) {
    // Define una clase extendida de FPDF para personalizar el diseño del PDF
    class PDF extends FPDF {
        // Cabecera de página
        function Header() {
            // Establece la fuente, el estilo y el tamaño del texto
            $this->SetFont('Arial','B',15);
            // Imprime un texto centrado en la página
            $this->Cell(190, 10, 'Factura Electronica', 0, 1, 'C');
            // Imprime un texto centrado en la página
            $this->Cell(190, 10, 'Fecha: ' . date("d/m/Y"), 0, 1, 'C');
            // Salta una línea
            $this->Ln(10);
        }

        // Pie de página
        function Footer() {
            // Posición a 1.5 cm del final de la página
            $this->SetY(-15);
            // Establece la fuente, el estilo y el tamaño del texto
            $this->SetFont('Arial','I',8);
            // Imprime un texto centrado en la página con el número de página
            $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

    // Crea una instancia de la clase PDF
    $pdf = new PDF();
    // Establece un alias para el número total de páginas
    $pdf->AliasNbPages();

    // Itera sobre cada fila del resultado de la consulta
    while ($row = $result->fetch_assoc()) {
        // Añade una nueva página al PDF
        $pdf->AddPage();

        // Establece la fuente y el tamaño del texto
        $pdf->SetFont('Arial','',12);

        // Información del Cliente
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10,'Informacion del Cliente:',0,1);
        $pdf->Cell(0,10,'Nombre: ' . utf8_decode($row["nombres"]) . ' ' . utf8_decode($row["apellidos"]),0,1);
        $pdf->Ln(10);

        // Detalle de la Reserva
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10,'Detalle de la Reserva:',0,1);
        $pdf->Cell(35,10,'Codigo Reserva',1,0, 'C');
        $pdf->Cell(45,10,'Fecha de inicio',1,0, 'C');
        $pdf->Cell(45,10,'Fecha fin',1,0, 'C');
        $pdf->Cell(40,10,'Tipo de Habitacion',1,0, 'C');
        $pdf->Cell(30,10,'Total reserva',1,1, 'C');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(35,10,$row["cod_reserva"],1,0);
        $pdf->Cell(45,10,$row["fecha_inicio"],1,0, 'C');
        $pdf->Cell(45,10,$row["fecha_fin"],1,0, 'C');
        $pdf->Cell(40,10,utf8_decode($row["nom_tipo_hab"]),1,0, 'C');
        $pdf->Cell(30,10,'$' . $row["valor_base"] * $row['dias_reserva'],1,1, 'C');

        // Detalle del Carrito       

        // Consulta el detalle del carrito para obtener todas las filas
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

        // Verifica si se encontraron filas en el resultado de la consulta del carrito
        $total_servicios_ads = 0;
            
        if ($carrito_result->num_rows > 0) {
            // Itera sobre cada fila del resultado de la consulta del carrito
            while ($carrito_row = $carrito_result->fetch_assoc()) {
                $pdf->SetFont('Arial','B',12);
                $pdf->Ln();
                $pdf->Cell(30,10,'ID Carrito',1,0);
                $pdf->Cell(30,10,'Documento',1,0, 'C');
                $pdf->Cell(30,10,'Cod Servicio',1,0, 'C');
                $pdf->Cell(40,10,'Nombre Producto',1,0, 'C');
                $pdf->Cell(25,10,'Cantidad',1,0, 'C');
                $pdf->Cell(40,10,'Subtotal',1,1, 'C');
                // Establece la fuente y el tamaño del texto
                $pdf->SetFont('Arial','',12);
                // Imprime las celdas con la información del carrito
                $pdf->Cell(30,10,$carrito_row["cod_carrito"],1,0);
                $pdf->Cell(30,10,$carrito_row["num_doc"],1,0, 'C');
                $pdf->Cell(30,10,$carrito_row["cod_servicio"],1,0, 'C');
                $pdf->Cell(40,10,isset($carrito_row["nom_bar"]) ? utf8_decode($carrito_row["nom_bar"]) : (isset($carrito_row["nom_restaurante"]) ? utf8_decode($carrito_row["nom_restaurante"]) : utf8_decode($carrito_row["nom_zonas_humedas"])),1,0, 'C');
                $pdf->Cell(25,10,$carrito_row["cantidad"],1,0, 'C');
                $pdf->Cell(40,10,'$' . $carrito_row["subtotal"],1,1, 'C');
                // Suma el subtotal al total de servicios adicionales
                $total_servicios_ads += $carrito_row['subtotal'];
            }
        }
        
        // Total Servicios Adicionales
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10,'Total SERVICIOS ADICIONALES: $' . $total_servicios_ads,0,1, 1);

        // Total Factura
        $pdf->SetFont('Arial','B',14);
        $total_factura = $row["valor_base"] * $row['dias_reserva'] + $total_servicios_ads;
        $pdf->Cell(0,10,'Total FACTURA: $' . $total_factura,0,1,'R');
    } // Fin del bucle while

    // Salida del PDF
    $pdf->Output('factura.pdf','I'); // 'I' para ver el archivo directamente en el navegador, 'D' para descargar directamente

} else {
    // Muestra un mensaje si no se encontraron detalles de factura
    echo "No se encontraron detalles de factura.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
