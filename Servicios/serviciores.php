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

//$numDoc = "1111"; // Reemplaza con el número de documento específico que estás utilizando

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //$numDoc = "1111";

    $codigoServicio = $_POST['CodigoServicio'];
    $id_agregadosrest = $_POST['id_agregadosrest'];
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 1;

    // Realiza la consulta SQL para obtener el valor del producto del bar
    $queryValorBar = "SELECT valor FROM restaurante WHERE id_rest = '$id_agregadosrest'";
    $resultadoValorBar = mysqli_query($bd, $queryValorBar);

    if (!$resultadoValorBar) {
        $errores[] = 'Error al obtener el valor del producto del restaurante: ' . mysqli_error($bd);
    } else {
        $filaValorBar = mysqli_fetch_assoc($resultadoValorBar);
        $valorBar = $filaValorBar['valor'];

        // Calcula el subtotal multiplicando la cantidad por el valor del bar
        $subtotal = $cantidad * $valorBar;

        // Inserta o actualiza el registro en la tabla carrito_persona
        $queryInsertarCarrito = "INSERT INTO carrito_persona (num_doc, cod_servicio, id_agregadosrest, cantidad, subtotal)
                                 VALUES ('$num', '$codigoServicio', '$id_agregadosrest', $cantidad, $subtotal)
                                 ON DUPLICATE KEY UPDATE cantidad = $cantidad, subtotal = $subtotal";

        $resultadoInsertarCarrito = mysqli_query($bd, $queryInsertarCarrito);

        if ($resultadoInsertarCarrito) {
            echo "<script type='text/javascript'>alert('Producto añadido correctamente');
            window.location='serviciores.php';
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
    <title>Restaurante</title>
</head>
<body>
    <header>
    <nav class="menu">
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
        <ul class="menu-principal">
            <li><a href="../Reserva/reserva.php">Reserva</a></li>
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
    </header>
    <div class="contenido">
        <section class="menu">
            <div class="alimento 1">
                <img src="../imagenes/bandeja.jpg" alt="">
                <div class="info">
                    <h3>Bandeja Paisa</h3>
                    <p>La Bandeja Paisa es un plato colombiano emblemático, especialmente asociado con la región de Antioquia. Es conocida por ser una comida abundante que combina una variedad de ingredientes. Incluye carne (molida o asada), arroz, frijoles, huevo frito, aguacate, plátano maduro frito, morcilla, arepas y hogao. Este plato representa la riqueza culinaria de Colombia y es apreciado por su mezcla de sabores y texturas. Es una opción popular para aquellos que buscan una experiencia gastronómica completa y satisfactoria.</p>
                    <h4>COP 40.000</h4>
                </div><!-- ... (código del primer alimento) ... -->
                <form class="formulario" method="POST" action="serviciores.php">
                    <input type="hidden" name="CodigoServicio" value="100">
                    <input type="hidden" name="id_agregadosrest" value="r1">
                    <label for="cantidad">Cantidad de Producto:</label> <!-- Puedes generar un ID único para cada item del carrito -->
                    <input type="number" id="cantidad" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
            </div>
            <div class="alimento 2">
                <img src="../imagenes/arroz.jpg" alt="">
                <div class="info">
                    <h3>Arroz chino</h3>
                    <p>El arroz chino es un platillo de la cocina asiática que consiste en arroz frito en un wok con ingredientes como verduras, carne y huevo. Es conocido por su versatilidad y delicioso sabor, siendo popular en todo el mundo.</p>
                    <h4>COP 40.000</h4>
                </div><!-- ... (código del primer alimento) ... -->
                <form class="formulario" method="POST" action="serviciores.php">
                    <input type="hidden" name="id_agregadosrest" value="r2">
                    <label for="cantidad">Cantidad de Producto:</label> <!-- Puedes generar un ID único para cada item del carrito -->
                    <input type="number" id="cantidad" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
            </div>
            <div class="alimento 3">
                <img src="../imagenes/ajiaco.jpg" alt="">
                <div class="info">
                    <h3>Sopa de Ajiaco</h3>
                    <p>La sopa de ajiaco es un plato tradicional de la cocina colombiana. Se caracteriza por ser espesa y abundante, con ingredientes clave como papas, mazorcas de maíz, guascas (hierba aromática), pollo, y varios tipos de papas. Se le añade alcaparras y crema de leche al momento de servir, proporcionando un sabor único y reconfortante. La sopa de ajiaco es especialmente apreciada por su riqueza y la combinación de sabores que reflejan la diversidad culinaria de Colombia.</p>
                    <h4>COP 15.000</h4>
                </div><!-- ... (código del primer alimento) ... -->
                <form class="formulario" method="POST" action="serviciores.php">
                    <input type="hidden" name="CodigoServicio" value="100">
                    <input type="hidden" name="id_agregadosrest" value="r3"> 
                    <label for="cantidad">Cantidad de Producto:</label><!-- Puedes generar un ID único para cada item del carrito -->
                    <input type="number" id="cantidad" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
            </div>
            <div class="alimento 4">
                <img src="../imagenes/sancocho.jpg" alt="">
                <div class="info">
                    <h3>Sancocho de Gallina</h3>
                    <p> El sancocho de gallina es un plato tradicional latinoamericano, presente en diversas variantes en diferentes países. Se prepara con gallina, y a veces pollo, cocidos lentamente con una variedad de vegetales como yuca, plátano, mazorcas de maíz, papa, entre otros. El caldo resultante es abundante y muy sabroso, impregnado con los sabores de los ingredientes. Es un plato reconocido por su carácter reconfortante y su presencia en celebraciones familiares y eventos especiales.</p>
                    <h4>COP 15.000</h4>
                </div>
                <!-- ... (código del primer alimento) ... -->
                <form class="formulario" method="POST" action="serviciores.php">
                    <input type="hidden" name="CodigoServicio" value="100">
                    <input type="hidden" name="id_agregadosrest" value="r4"> 
                    <label for="cantidad">Cantidad de Producto:</label><!-- Puedes generar un ID único para cada item del carrito -->
                    <input type="number" id="cantidad" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
            </div>
            <div class="alimento 5">
                <img src="../imagenes/pollo.jpg" alt="">
                <div class="info">
                    <h3>Pollo Asado</h3>
                    <p>El pollo asado es un plato popular que se prepara asando pollo sazonado al horno, a la parrilla o a la brasa. Antes de la cocción, el pollo se adoba con especias, hierbas, aceite de oliva u otros condimentos para realzar su sabor. El resultado es una piel crujiente por fuera y una carne jugosa por dentro. El pollo asado es versátil y se sirve comúnmente como plato principal en comidas familiares o eventos. Puede acompañarse de diversas guarniciones, como patatas asadas, vegetales al vapor o ensaladas, según las preferencias culinarias.</p>
                    <h4>COP 30.000</h4>
                </div><!-- ... (código del primer alimento) ... -->
                <form class="formulario" method="POST" action="serviciores.php">
                    <input type="hidden" name="CodigoServicio" value="100">
                    <input type="hidden" name="id_agregadosrest" value="r5">
                    <label for="cantidad">Cantidad de Producto:</label> <!-- Puedes generar un ID único para cada item del carrito -->
                    <input type="number" id="cantidad" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
            </div>
            <div class="botones-acciones">
                <a href="vercarrito.php" class="boton-ver-carrito">Ver Carrito</a>
            </div>
        </section>
    </div>
</body>
</html>