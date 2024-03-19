<?php
// Incluir el archivo fpdf.php desde la carpeta fpdf
require_once('fpdf/fpdf.php');
require_once("conexion.php");

// Verificar si hay una sesión iniciada
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    die("No hay un usuario logeado.");
}

// Obtener el ID del usuario logeado
$user_id = $_SESSION['user_id'];

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
    persona.id_usuario = '$user_id'";

$result = $conn->query($sql);

if ($result === false) {
    die("Error en la consulta: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Obtener la primera fila de resultados

    // Crear una clase extendida de FPDF para personalizar el diseño
    class PDF extends FPDF {
        // Cabecera de página
        function Header() {
            $this->SetFont('Arial','B',15);
            $this->Cell(190, 10, 'Factura Electronica', 0, 1, 'C');
            $this->Ln(10); // Saltar línea
        }

        // Pie de página
        function Footer() {
            $this->SetY(-15); // Posición a 1.5 cm del final
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

    // Crear instancia de PDF
    $pdf = new PDF();
    $pdf->AliasNbPages(); // Establecer el número total de páginas

    // Añadir página
    $pdf->AddPage();

    // Establecer fuente y tamaño de texto
    $pdf->SetFont('Arial','',12);

    // Información del Cliente
    $pdf->Cell(0,10,'Información del Cliente:',0,1);
    $pdf->Cell(0,10,'Nombre: ' . $row["nombres"] . ' ' . $row["apellidos"],0,1);
    $pdf->Ln(10); // Saltar línea

    // Detalle de la Reserva
    $pdf->Cell(0,10,'Detalle de la Reserva:',0,1);
    $pdf->Cell(35,10,'Código Reserva',1,0);
    $pdf->Cell(45,10,'Fecha de inicio',1,0);
    $pdf->Cell(45,10,'Fecha fin',1,0);
    $pdf->Cell(40,10,'Tipo de Habitacion',1,0);
    $pdf->Cell(35,10,'Valor total de la reserva',1,1);
    $pdf->Cell(35,10,$row["cod_reserva"],1,0);
    $pdf->Cell(45,10,$row["fecha_inicio"],1,0);
    $pdf->Cell(45,10,$row["fecha_fin"],1,0);
    $pdf->Cell(40,10,$row["nom_tipo_hab"],1,0);
    $pdf->Cell(35,10,'$' . $row["valor_base"] * $row['dias_reserva'],1,1);
    $pdf->Ln(10); // Saltar línea

    // Detalle de la Factura
    $pdf->Cell(0,10,'Detalle de la Factura:',0,1);
    $pdf->Cell(35,10,'Codigo factura',1,0);
    $pdf->Cell(45,10,'Descripcion',1,0);
    $pdf->Cell(40,10,'Precios Totales',1,1);
    $pdf->Cell(35,10,$row["cod_factura"],1,0);
    $pdf->Cell(45,10,'Servicio',1,0);
    $pdf->Cell(40,10,'$' . $row["subtotal"],1,1);
    $pdf->Cell(35,10,$row["cod_factura"],1,0);
    $pdf->Cell(45,10,'Reserva',1,0);
    $pdf->Cell(40,10,'$' . $row["valor_base"] * $row['dias_reserva'],1,1);
    $pdf->Ln(10); // Saltar línea

    // Total Factura
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10,'Total FACTURA: $' . ($row["subtotal"] + $row["valor_base"] * $row['dias_reserva']),0,1,'R');

    // Salida del PDF
    $pdf->Output('factura.pdf','I'); // 'I' para ver el archivo directamente en el navegador, 'D' para descargar directamente
} else {
    echo "No se encontraron detalles de factura.";
}

// Cerrar conexión
$conn->close();
