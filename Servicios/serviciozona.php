<?php
require '../Bd/conexion.php';

$bd = conectar_db();
$errores = [];

session_start();

if (!isset($_SESSION['correo_electronico'])) {
    header("Location:../Usuarios/iniciarsesion.php");
}
$id=$_SESSION['correo_electronico'];
$sql="SELECT * FROM persona WHERE correo_electronico='$id'";
$resultado=mysqli_query($bd,$sql);
$datos=mysqli_fetch_assoc($resultado);
$num=$datos['num_doc'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //$numDoc = "1111";
    $codigoServicio = $_POST['CodigoServicio'];
    $id_agregadoszona = $_POST['id_agregadoszonas']; // Corregido el nombre del campo
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 1;

    // Realiza la consulta SQL para obtener el valor del producto de zonas humedas
    $queryValorZona = "SELECT valor FROM zonas_humedas WHERE id_zon_hum = '$id_agregadoszona'";
    $resultadoValorZona = mysqli_query($bd, $queryValorZona);

    if (!$resultadoValorZona) {
        $errores[] = 'Error al obtener el valor del producto de zonas humedas: ' . mysqli_error($bd);
    } else {
        $filaValorZona = mysqli_fetch_assoc($resultadoValorZona);
        $valorZona = $filaValorZona['valor'];

        // Calcula el subtotal multiplicando la cantidad por el valor de zonas humedas
        $subtotal = $cantidad * $valorZona;

        // Inserta o actualiza el registro en la tabla carrito_persona
        $queryInsertarCarrito = "INSERT INTO carrito_persona (num_doc, cod_servicio, id_agregadoszonas, cantidad, subtotal)
                                 VALUES ('$num', '$codigoServicio', '$id_agregadoszona', $cantidad, $subtotal)
                                 ON DUPLICATE KEY UPDATE cantidad = $cantidad, subtotal = $subtotal";

        $resultadoInsertarCarrito = mysqli_query($bd, $queryInsertarCarrito);

            if ($resultadoInsertarCarrito) {    
    // Enviar una respuesta clara
            echo "Inserción exitosa";
            exit(); // Terminar la ejecución del script después de enviar la respuesta
            } else {
            $errores[] = 'Error al insertar/actualizar en la tabla carrito_persona: ' . mysqli_error($bd);
            }
    }
}

// Cierra la conexión a la base de datos
mysqli_close($bd);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha256-xxxxxx" crossorigin="anonymous" />
    <link rel="stylesheet" href="../diseño/estilo.css">
    <link rel="icon" href="../imagenes/playa.png">
    <title>Zonas Humedas</title>
</head>
<body>
    <nav class="menu">
        <a href="../index.html"><img src="../imagenes/logo verde.png" alt="" class="logo"></a>
        <ul class="menu-principal">
            <li><a href="../Reserva/reserva.html">Reserva</a></li>
            <ul class="submenu">
                <li><a href="">Crear Reserva</a></li>
                <li><a href="">Eliminar Reserva</a></li>
                <li><a href="">Consultar Reservas</a></li>
            </ul>
            <li><a href="">Habitaciones</a>
                <ul class="submenu">
                    <li><a href="">Sencilla</a></li>
                    <li><a href="">Doble</a></li>
                    <li><a href="">Triple</a></li>
                    <li><a href="">Familiar</a></li>
                </ul>
            </li>
            <li><a href="../Usuarios/vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="">Eliminar cuenta</a></li>
                    <li><a href="">Recuperar contraseña</a></li>
                </ul>
            </li>
            <li><a href="">Contáctenos</a></li>
            <li><a href="servicios.html">Servicios</a></li>
        </ul>
    </nav>
    <div class="contenido">
        <section class="zonas">
            <div class="humeda 1">
                <img src="../imagenes/spaser.jpg" alt="">
                <div class="info">
                    <h3>Spa</h3>
                    <p>
                        Un spa es un refugio de tranquilidad y rejuvenecimiento que busca proporcionar a sus visitantes una experiencia holística para el cuidado del cuerpo y la mente. Sus instalaciones suelen contar con ambientes serenos y acogedores, con una atención centrada en el cliente.</p>
                    <h4>COP 50.000</h4>
                </div>
                <form class="formulario" method="POST" action="serviciozona.php">
                    <input type="hidden" name="NumeroDocumento" value="1111">
                    <input type="hidden" name="CodigoServicio" value="100">
                    <input type="hidden" name="id_agregadoszonas" value="z1"> <!-- Asigna valores únicos según el servicio -->
                    <label for="cantidad_zona">Cantidad de Personas:</label>
                    <input type="number" id="cantidad_zona" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
            </div>

            <div class="humeda 2">
                <img src="../imagenes/piscinaser.jpg" alt="">
                <div class="info">
                    <h3>Piscina</h3>
                    <p>Una piscina es un oasis acuático que puede encontrarse tanto en espacios privados, como en patios traseros, como en instalaciones públicas, como clubes, hoteles o complejos recreativos. Su diseño puede variar, pero generalmente consta de un área revestida con material impermeable, como azulejos o láminas de vinilo, que retiene el agua.</p>
                    <h4>COP 20.000</h4>
                </div>
                <form class="formulario" method="POST" action="serviciozona.php">
                    <input type="hidden" name="NumeroDocumento" value="1111">
                    <input type="hidden" name="CodigoServicio" value="100">
                    <input type="hidden" name="id_agregadoszonas" value="z2"> <!-- Asigna valores únicos según el servicio -->
                    <label for="cantidad_zona">Cantidad de Personas:</label>
                    <input type="number" id="cantidad_zona" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
            </div>
            <div class="botones-acciones">
                <a href="vercarrito.php" class="boton-ver-carrito">Ver Carrito</a>
            </div>
        </section>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Agrega este script para manejar la respuesta de inserción exitosa
        const formulario = document.querySelector('.formulario');
        formulario.addEventListener('submit', function (event) {
            event.preventDefault();

            // Utiliza Fetch API para realizar una solicitud POST asíncrona
            fetch(this.action, {
                method: this.method,
                body: new FormData(this),
            })
            .then(response => response.text())  // Cambia a text() para manejar una respuesta de texto
            .then(data => {
                // Verifica si la inserción fue exitosa
                if (data === 'Inserción exitosa') {
                    alert('Inserción exitosa');
                } else {
                    alert('Error al insertar en la base de datos');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                alert('Error en la solicitud');
            });
        });
    });
</script>
</body>
</html> 

