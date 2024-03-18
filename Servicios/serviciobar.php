<?php
require '../Bd/conexion.php';

$bd = conectar_db();
$errores = [];
$numDoc = ""; // Reemplaza con el número de documento específico que estás utilizando

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
    $codigoServicio = $_POST['CodigoServicio'];
    $id_agregadosbar = $_POST['id_agregadosbar'];
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 1;

    $queryValorBar = "SELECT valor FROM bar WHERE id_bar = '$id_agregadosbar'";
    $resultadoValorBar = mysqli_query($bd, $queryValorBar);

    if (!$resultadoValorBar) {
        $errores[] = 'Error al obtener el valor del producto del bar: ' . mysqli_error($bd);
    } else {
        $filaValorBar = mysqli_fetch_assoc($resultadoValorBar);
        $valorBar = $filaValorBar['valor'];

        // Calcula el subtotal multiplicando la cantidad por el valor del bar
        $subtotal = $cantidad * $valorBar;

        // Inserta o actualiza el registro en la tabla carrito_persona
        $queryInsertarCarrito = "INSERT INTO carrito_persona (num_doc, cod_servicio, id_agregadosbar, cantidad, subtotal)
                                 VALUES ('$num', '$codigoServicio', '$id_agregadosbar', $cantidad, $subtotal)
                                 ON DUPLICATE KEY UPDATE cantidad = $cantidad, subtotal = $subtotal";

        $resultadoInsertarCarrito = mysqli_query($bd, $queryInsertarCarrito);

        if ($resultadoInsertarCarrito) {
            echo "<script type='text/javascript'>alert('Producto añadido correctamente');
            window.location='serviciobar.php';
            </script>";
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
    <link rel="icon" href="../imagenes/logo.png">
    <title>Bar</title>
</head>
<body>
<header>
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
        <nav class="menu">
            <ul class="menu-principal">
                <li><a href="../Reserva/reserva.php">Reserva</a></li>
                <ul class="submenu">
                    <li><a href="">Crear Reserva</a></li>
                    <li><a href="">Eliminar Reserva</a></li>
                    <li><a href="">Consultar Reservas</a></li>
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
        <section class="serviciosl">
            <div class="carrito">
                <a href="vercarrito.php" class="boton-ver-carrito"><img src="../imagenes/carrito.png" alt="" srcset=""></a>
            </div>
            <div class="serviciosa 1">
                <img src="../imagenes/margarita.jpg" alt="">
                <div class="info">
                    <h3>Margarita</h3>
                    <p class="p1">
                        La Margarita es un cóctel clásico que combina tequila, triple sec (licor de naranja) y jugo de limón o lima. Se caracteriza por su refrescante sabor cítrico y su distintivo equilibrio entre la dulzura y la acidez. Este cóctel suele ser servido en un vaso escarchado con sal en el borde, lo que añade un toque adicional de salinidad que complementa perfectamente los sabores.</p>
                    <h4>COP 10.000</h4>
                </div>
                <form class="formulario" method="POST" action="serviciobar.php">
                    <input type="hidden" name="CodigoServicio" value="100">
                    <input type="hidden" name="id_agregadosbar" value="b1">
                    <label for="cantidad">Cantidad de Producto:</label> <!-- Puedes generar un ID único para cada item del carrito -->
                    <input class="add-cantidad" type="number" id="cantidad" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
            </div>

            <div class="serviciosa 2">
                <img src="../imagenes/whisky.jpg" alt="">
                <div class="info">
                    <h3>Whisky</h3>
                    <p>El whisky es una bebida alcohólica destilada que se obtiene a partir de la fermentación y destilación de granos malteados, como la cebada, maíz, centeno o trigo. Su nombre proviene del gaélico escocés "uisge beatha" o del irlandés "uisce beathadh", que significan "agua de vida". Este licor tiene una larga historia y es apreciado en todo el mundo por su complejidad de sabores y aromas.</p>
                    <h4>COP 20.000</h4>
                </div>
                <form class="formulario" method="POST" action="serviciobar.php">
                    <input type="hidden" name="CodigoServicio" value="100">
                    <input type="hidden" name="id_agregadosbar" value="b2">
                    <label for="cantidad">Cantidad de Producto:</label>
                    <input class="add-cantidad" type="number" id="cantidad" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
            </div>

            <div class="serviciosa 3">
                <img src="../imagenes/malibu.jpg" alt="">
                <div class="info">
                    <h3>Malibu</h3>
                    <p>Malibu es una marca de licor conocida por su ron con sabor a coco. Es una bebida espirituosa que se ha vuelto popular en cócteles tropicales y otras mezclas refrescantes. Malibu se caracteriza por su sabor dulce y tropical, con un toque distintivo de coco.</p>
                    <h4>COP 15.000</h4>
                </div>
                <form class="formulario" method="POST" action="serviciobar.php">
                    <input type="hidden" name="CodigoServicio" value="100">
                    <input type="hidden" name="id_agregadosbar" value="b3">
                    <label for="cantidad">Cantidad de Producto:</label> <!-- Puedes generar un ID único para cada item del carrito -->
                    <input type="number" class="add-cantidad" id="cantidad" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
            </div>
            <div class="serviciosa 4">
                <img src="../imagenes/vinoblanco.jpg" alt="">
                <div class="info">
                    <h3>Vino Blanco</h3>
                    <p> El vino blanco es un tipo de vino elaborado principalmente a partir de uvas de color verde o amarillo claro. A diferencia del vino tinto, se produce fermentando el mosto sin la piel de las uvas, lo que le confiere su color claro. Hay una amplia variedad de estilos y sabores de vino blanco, ya que diferentes cepas de uva y métodos de vinificación pueden resultar en perfiles de sabor distintos. </p>
                    <h4>COP 8.000</h4>
                </div>
                <form class="formulario" method="POST" action="serviciobar.php">
                    <input type="hidden" name="CodigoServicio" value="100">
                    <input type="hidden" name="id_agregadosbar" value="b4">
                    <label for="cantidad">Cantidad de Producto:</label> <!-- Puedes generar un ID único para cada item del carrito -->
                    <input type="number" class="add-cantidad" id="cantidad" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
            </div>
            <div class="serviciosa 5">
                <img src="../imagenes/vino.jpg" alt="">
                <div class="info">
                    <h3>Vino de Uva</h3>
                    <p>
                        El término "vino de uva" se refiere simplemente a cualquier vino que se produce a partir de la fermentación del jugo de uva. La uva es la fruta principal utilizada en la producción de vino, y existen muchas variedades de uvas viníferas que se cultivan en todo el mundo para elaborar vinos con una amplia variedad de perfiles de sabor.</p>
                    <h4>COP 8.000</h4>
                </div>
                <form class="formulario" method="POST" action="serviciobar.php">
                    <input type="hidden" name="CodigoServicio" value="100">
                    <input type="hidden" name="id_agregadosbar" value="b5"> 
                    <label for="cantidad">Cantidad de Producto:</label><!-- Puedes generar un ID único para cada item del carrito -->
                    <input type="number" class="add-cantidad" id="cantidad" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
            </div>
            <br>
        </section>
    </div>
</body>
</html>