<?php
require '../Bd/conexion.php';

if (isset($_GET['id_carrito']) && isset($_GET['nueva_cantidad']) && isset($_GET['nuevo_subtotal'])) {
    // Obtén el ID del carrito, la nueva cantidad y el nuevo subtotal desde la solicitud GET
    $idCarrito = $_GET['id_carrito'];
    $nuevaCantidad = $_GET['nueva_cantidad'];
    $nuevoSubtotal = $_GET['nuevo_subtotal'];

    // Conectar a la base de datos
    $bd = conectar_db();

    // Actualizar la cantidad y el subtotal en la base de datos
    $queryActualizarCantidad = "UPDATE carrito_persona SET cantidad = $nuevaCantidad, subtotal = $nuevoSubtotal WHERE cod_carrito = $idCarrito";
    $resultadoActualizarCantidad = mysqli_query($bd, $queryActualizarCantidad);

    // Manejar el resultado de la actualización
    if ($resultadoActualizarCantidad) {
        // Puedes enviar una respuesta JSON si es necesario
        // echo json_encode(['success' => true]);
        // O simplemente enviar una respuesta
        echo "Cantidad y subtotal actualizados correctamente";
    } else {
        // Puedes enviar una respuesta JSON si es necesario
        // echo json_encode(['error' => mysqli_error($bd)]);
        // O simplemente enviar una respuesta
        echo "Error al actualizar la cantidad y el subtotal: " . mysqli_error($bd);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($bd);
} else {
    // Manejar el caso en que no se proporcionó el ID del carrito, la nueva cantidad o el nuevo subtotal
    echo "Error: No se proporcionó información completa para actualizar la cantidad y el subtotal.";
}
?>