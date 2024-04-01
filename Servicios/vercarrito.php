<?php
require '../Bd/conexion.php';

// Conectar a la base de datos
$bd = conectar_db();
session_start();

if (!isset($_SESSION['correo_electronico'])) {
    header("Location:../Usuarios/iniciarsesion.php");
}
$id=$_SESSION['correo_electronico'];
$sql="SELECT * FROM persona WHERE correo_electronico='$id'";
$resultado=mysqli_query($bd,$sql);
$datos=mysqli_fetch_assoc($resultado);
$num=$datos['num_doc'];


$queryVerCarrito = "SELECT c.cod_carrito, c.num_doc, c.cod_servicio, 
                           r.nom_producto_rest as nombre_producto_rest,
                           b.nom_producto_bar as nombre_producto_bar,
                           z.nom_servicio_zh as nombre_producto_zh,
                           c.cantidad, c.subtotal
                    FROM carrito_persona c
                    LEFT JOIN restaurante r ON c.id_agregadosrest = r.id_rest
                    LEFT JOIN bar b ON c.id_agregadosbar = b.id_bar
                    LEFT JOIN zonas_humedas z ON c.id_agregadoszonas = z.id_zon_hum  WHERE num_doc='$num'";
$resultadoVerCarrito = mysqli_query($bd, $queryVerCarrito);

// Verificar si hay resultados
if ($resultadoVerCarrito) {
    $filasCarrito = mysqli_fetch_all($resultadoVerCarrito, MYSQLI_ASSOC);
} else {
    $errorConsulta = mysqli_error($bd);
    echo "Error al obtener los datos del carrito: $errorConsulta";
}
mysqli_close($bd);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../diseño/estilocar.css">
    <link rel="icon" href="../imagenes/logo.png">
    <title>Carrito</title>
</head>
<body>
<header>
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
        <nav class="menu">
            <ul class="menu-principal">
                <li><a href="../Reserva/ver_reservas.php">Reserva</a></li>
                <ul class="submenu">
                </ul>
                <li><a href="../Habitaciones/habitaciones.php">Habitaciones</a></li>
            <?php if(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']!=2):?>
            <li><a href="../Usuarios/vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="../Usuarios/salir.php" onclick='return confirmacion()'>Salir</a></li>
                </ul>
            </li>
            <?php elseif(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']==2):?>
            <li><a href="../Usuarios/vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="../Usuarios/opciones.php">Opciones</a></li>
                    <li><a href="../Usuarios/salir.php" onclick='return confirmacion()'>Salir</a></li>
                </ul>
                </li>
            <?php else :?>
            <li><a href="../Usuarios/iniciarsesion.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="../Usuarios/iniciarsesion.php">Iniciar sesión</a></li>
                    <li><a href="../Usuarios/crear.php">Registrarse</a></li>
                </ul>
            </li>
            <?php endif;?>
            <li><a href="">Contáctenos</a></li>
            <li><a href="servicios.php">Servicios</a>
                <ul class="submenu">
                    <li><a href="serviciores.php">Restaurante</a></li>
                    <li><a href="serviciobar.php">Bar</a></li>
                    <li><a href="serviciozona.php">Zonas húmedas</a></li>
                </ul>
            </li>
    </ul>
    </nav>
    </header>
    <div class="contenido">
    <h1 class="titulo-carrito">Contenido del Carrito</h1>
    
    <?php if (isset($filasCarrito) && !empty($filasCarrito)) : ?>
        <table class="tabla-carrito">
            <thead>
                <tr>
                    <th>ID Carrito</th>
                    <th>Número de Documento</th>
                    <th>Código de Servicio</th>
                    <th>Nombre del Producto (Restaurante)</th>
                    <th>Nombre del Producto (Bar)</th>
                    <th>Nombre del Producto (Zonas Húmedas)</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th colspan="9">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filasCarrito as $fila) : ?>
                    <tr>
                        <td><?= $fila['cod_carrito'] ?></td>
                        <td><?= $fila['num_doc'] ?></td>
                        <td><?= $fila['cod_servicio'] ?></td>
                        <td><?= $fila['nombre_producto_rest'] ?></td>
                        <td><?= $fila['nombre_producto_bar'] ?></td>
                        <td><?= $fila['nombre_producto_zh'] ?></td>
                        <td id="cantidad<?= $fila['cod_carrito'] ?>"><?= $fila['cantidad'] ?></td>
                        <td id="valorProducto<?= $fila['subtotal'] ?>"></td>
                        <td>
                            <button class="eliminar-btn" onclick="eliminarProducto(<?= $fila['cod_carrito'] ?>)">
                              <img src="../imagenes/dele.png" alt="">
                            </button>
                        </td>
                        <td>
                        <button class="actualizar-cantidad-btn" onclick="mostrarFormularioActualizar(<?= $fila['cod_carrito'] ?>)"><img src="../imagenes/editar.png" alt="">
                        </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Formulario oculto para actualizar la cantidad -->
        <div id="formularioActualizar" style="display: none;">
            <form id="formActualizarCantidad" onsubmit="return actualizarCantidad();">
                <!-- Agrega un campo oculto para enviar el nuevo subtotal -->
                <input type="hidden" id="nuevoSubtotal" name="nuevoSubtotal">
                <label for="nuevaCantidad">Nueva Cantidad:</label>
                <input type="number" id="nuevaCantidad" name="nuevaCantidad" min="1" required>
                <button type="button" onclick="actualizarCantidad()">Actualizar</button>
            </form>
        </div>
    <?php else : ?>
        <!-- Mensaje si no hay elementos en el carrito -->
        <p class="mensaje-carrito">No hay elementos en el carrito.</p>
    <?php endif; ?>
    </div>

    <script>
        function eliminarProducto(idCarrito) {
            // Confirmar con el usuario antes de eliminar
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                // Llamada AJAX para eliminar el producto en el servidor
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        // La respuesta del servidor puede contener información adicional si es necesario
                        alert(this.responseText);
                        // Actualizar la página o realizar cualquier otra acción necesaria
                        location.reload();
                    }
                };
                xhttp.open("GET", "eliminar_producto.php?id_carrito=" + idCarrito, true);
                xhttp.send();
            }
        }

        function mostrarFormularioActualizar(idCarrito) {
            // Mostrar el formulario de actualización
            document.getElementById("formularioActualizar").style.display = "block";
            // Prellenar el campo de nueva cantidad con la cantidad actual del producto
            document.getElementById("nuevaCantidad").value = document.getElementById("cantidad" + idCarrito).innerText;
            // Asignar el ID del carrito al formulario
            document.getElementById("formActualizarCantidad").setAttribute("data-idcarrito", idCarrito);
        }

        function actualizarCantidad() {
            // Obtener el ID del carrito del formulario
            var idCarrito = document.getElementById("formActualizarCantidad").getAttribute("data-idcarrito");
            // Obtener la nueva cantidad ingresada por el usuario
            var nuevaCantidad = document.getElementById("nuevaCantidad").value;

            // Validar que la nueva cantidad sea un número positivo
            if (nuevaCantidad > 0) {
                // Calcular el nuevo subtotal
                var valorProducto = parseFloat(document.getElementById("valorProducto" + idCarrito).innerText);
                var nuevoSubtotal = (parseFloat(nuevaCantidad) * valorProducto).toFixed(2);

                // Actualizar el subtotal en el campo oculto
                document.getElementById("nuevoSubtotal").value = nuevoSubtotal;

                // Llamada AJAX para actualizar la cantidad y el subtotal en el servidor
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        // La respuesta del servidor puede contener información adicional si es necesario
                        alert(this.responseText);
                        // Ocultar el formulario después de la actualización
                        document.getElementById("formularioActualizar").style.display = "none";
                        // Actualizar la página o realizar cualquier otra acción necesaria
                        location.reload();
                    }
                };

                // Cambia la URL y agrega el parámetro para el nuevo subtotal
                xhttp.open("GET", "actualizar_cantidad.php?id_carrito=" + idCarrito + "&nueva_cantidad=" + nuevaCantidad + "&nuevo_subtotal=" + nuevoSubtotal, true);
                xhttp.send();
            } else {
                // Mostrar un mensaje de error si la nueva cantidad no es válida
                alert("Por favor, ingresa una cantidad válida.");
            }

            // Evitar que el formulario se envíe y recargue la página
            return false;
        }
    </script>
</body>
</html>






