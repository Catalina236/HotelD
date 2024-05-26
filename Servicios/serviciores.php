<?php
require '../Bd/conexion.php';

$bd = conectar_db();
$errores = [];

session_start();
$sql2="SELECT * FROM restaurante";
$resultado2=mysqli_query($bd,$sql2);
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
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
        <nav class="menu">
            <ul class="menu-principal">
                <li><a href="../Reserva/ver_reservas.php">Reserva</a></li>
                <ul class="submenu">
                </ul>
                <li><a href="../Habitaciones/habitaciones.php">Habitaciones</a></li>
            <?php if(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']!=2):?>
            <li><a href="Usuarios/vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="Usuarios/salir.php" onclick='return confirmacion()'>Salir</a></li>
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
            <li><a href="Usuarios/iniciarsesion.php">Mi Perfil</a>
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
        <section class="menu">
        <div class="carrito">
                <a href="vercarrito.php" class="boton-ver-carrito"><img src="../imagenes/carrito.png" alt="" srcset=""></a>
        </div>
        <?php while($servicios=mysqli_fetch_assoc($resultado2)){?>
            <div class="serviciosa 1">
                <img class="restaurante" src="../admin/clases/Servicios/imagenes/<?php echo $servicios['foto_serv'];?>" alt="">
                <div class="info">
                    <h3><?php echo $servicios['nom_producto_rest'];?> </h3>
                    <p><?php echo $servicios ['descripcion'];?></p>
                    <h4><?php echo $servicios['valor'];?></h4>
                </div>
                <div class="form-cantidad">
                <form class="formulario" method="POST" action="serviciores.php">
                    <label for="cantidad">Cantidad de Producto:</label> <!-- Puedes generar un ID único para cada item del carrito -->
                    <input type="hidden" name="cod_servicio" value="<?php echo $servicios['cod_servicio']; ?>">
                    
                    <input type="hidden" name="id_rest" value="<?php echo $servicios['id_rest']; ?>">
                    <input type="number" class="add-cantidad" id="cantidad" name="cantidad" min="1" required>
                    <button class="botonres" type="submit">Añadir al carrito</button>
                </form>
                </div>
            </div>
            <?php }?>
        </section>
    </div>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_SESSION['correo_electronico'])) {
        $_SESSION["redirect_to"]=$_SERVER["REQUEST_URI"];
        echo "<script type='text/javascript'>alert('Para añadir servicios al carrito debe iniciar sesión');
        window.location='../Usuarios/iniciarsesion.php';
        </script>";
    }
    $id=$_SESSION['correo_electronico'];
    $sql="SELECT * FROM persona WHERE correo_electronico='$id'";
    $resultado=mysqli_query($bd,$sql);
    $datos=mysqli_fetch_assoc($resultado);
    $num=$datos['num_doc'];
    

    $id=$_POST['id_rest'];
    $codigoServicio=$_POST['cod_servicio'];
    
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 1;
    // Realiza la consulta SQL para obtener el valor del producto del bar
    $queryValorBar = "SELECT * FROM restaurante WHERE id_rest = '$id'";
    $resultadoValorBar = mysqli_query($bd, $queryValorBar);

    if (!$resultadoValorBar) {
        $errores[] = 'Error al obtener el valor del producto del restaurante: ' . mysqli_error($bd);
    } else {
        $filaValorBar = mysqli_fetch_assoc($resultadoValorBar);
        $valorBar = $filaValorBar['valor'];

        // Calcula el subtotal multiplicando la cantidad por el valor del bar
        $subtotal = $cantidad * $valorBar;
        var_dump($subtotal);
        // Inserta o actualiza el registro en la tabla carrito_persona
        $queryInsertarCarrito = "INSERT INTO carrito_persona (num_doc, cod_servicio, id_agregadosrest, cantidad, subtotal) VALUES ('$num', '$codigoServicio', '$id', $cantidad, $subtotal)
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
