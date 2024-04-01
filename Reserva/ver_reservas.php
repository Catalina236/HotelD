<?php
require '../Bd/conexion.php';
$bd = conectar_db();
session_start();
if (!isset($_SESSION['correo_electronico'])) {
    echo "<script type='text/javascript'>alert('Para ver sus reservas, debe iniciar sesión');
    window.location='../Usuarios/iniciarsesion.php';
    </script>";
}
$email = $_SESSION['correo_electronico'];
$sql1 = "SELECT * FROM persona WHERE correo_electronico='$email'";
$result = mysqli_query($bd, $sql1);
$datos = mysqli_fetch_assoc($result);
$num = $datos['num_doc'];
$sql = "SELECT * FROM reserva JOIN habitacion ON reserva.cod_tipo_hab=habitacion.cod_tipo_hab JOIN tipo_habitacion ON tipo_habitacion.cod_tipo_hab=habitacion.cod_tipo_hab WHERE num_doc='$num'";
$resultado = mysqli_query($bd, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="../diseño/estilo.css">
    <title>Reservas</title>
</head>
<body>
<header>
    <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
    <nav class="menu">
        <ul class="menu-principal">
        <li><a href="../Reserva/ver_reservas.php">Reserva</a>
            <ul class="submenu">
            </ul>
            </li>
            <li><a href="../habitaciones/habitaciones.php">Habitaciones</a></li>
            <?php if (isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario'] != 2) : ?>
                <li><a href="../Usuarios/vercuenta.php">Mi Perfil</a>
                    <ul class="submenu">
                        <li><a href="../Usuarios/salir.php" onclick='return confirmacion()'>Salir</a></li>
                    </ul>
                </li>
            <?php elseif (isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario'] == 2) : ?>
                <li><a href="../Usuarios/vercuenta.php">Mi Perfil</a>
                    <ul class="submenu">
                        <li><a href="../Usuarios/opciones.php">Opciones</a></li>
                        <li><a href="../Usuarios/salir.php" onclick='return confirmacion()'>Salir</a></li>
                    </ul>
                </li>
            <?php else : ?>
                <li><a href="../Usuarios/iniciarsesion.php">Mi Perfil</a>
                    <ul class="submenu">
                        <li><a href="../Usuarios/iniciarsesion.php">Iniciar sesión</a></li>
                        <li><a href="../Usuarios/crear.php">Registrarse</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <li><a href="">Contáctenos</a></li>
            <li><a href="../Servicios/servicios.php">Servicios</a>
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
    <h1>Tus reservas</h1>   
    <br>
    <?php
    while ($reservas = mysqli_fetch_assoc($resultado)) {
        ?>
        <button class="btn_ver_detalles">
            <img src="../admin/clases/Habitacion/imagenes/<?php echo $reservas['imagen']; ?>" alt="">
            <div class="contenido-btn">
                <a href="ver_detalles_reserva.php?cod_reserva=<?php echo $reservas['cod_reserva']; ?>">
                    <br>
                    <h4>Habitación <?php echo $reservas['nom_tipo_hab']; ?></h4>
                    <h5>COP <?php echo $reservas['precio']; ?></h5>
                    <br>
                    <span><?php echo $reservas['fecha_inicio'] . " - " . $reservas['fecha_fin']; ?></span>
                </a>
                <div class="container">
                    <div class="group-menu" onclick="toggleMenu()">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                    <div class="frame1" id="frame1">
                        <div class="info"><span><a href="cancelar_reserva.php?cod_reserva=<?php echo $reservas['cod_reserva'];?>" onclick="return confirmacion()">Cancelar Reserva</a></span></div>
                        <div class="info"><a href="editar.php?cod_reserva=<?php echo $reservas['cod_reserva']; ?>">Modificar Reserva</a></div>
                        <div class="info"><a href="../factura/consulta_factura.php?cod_reserva=<?php echo $reservas['cod_reserva']; ?>">Ver factura</a></div>
                    </div>
                </div>
        </button>
    <?php } ?>
    </div>
    <?php if (mysqli_num_rows($resultado) == 0) : ?>
        <div class="mensaje-sin-reservas">
            <p>Aún no tienes reservas activas.</p>
            <a href="../Habitaciones/habitaciones.php" class="btn-reservar">¡Reserva ahora!</a>
        </div>
    <?php endif; ?>
</div>

<footer class="piepag">
    <section class="informacion">
        <h3>Ubicación</h3>
        <p>Soacha Cundinamarca</p>
        <p>Calle 30</p>
    </section>
        
        <section class="informacion2">
            <h3>Contacto</h3>
            <a href=""><p>32569785211</p></a>
            <a href=""><p>hotelerismosena76@sena.edu.co</p></a>
        </section>
        
        <section class="iconos">
            <h3>Nuestras redes</h3>
            <a href="https://web.facebook.com/sena.soacha/?locale=es_LA&_rdc=1&_rdr"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://twitter.com/i/flow/login?redirect_after_login=%2Fsenasoachacide"><i class="fa-brands fa-twitter"></i></a>
            <a href=""><i class="fa-brands fa-instagram"></i></a>
        </section>
        <div class="terminos">
            <p>Terms & Conditions / Privacy & Cookie Statement</p>
            <p>© 2023 
            All Rights Reserved | Hotel Aurora Oasis | Powered by Cloudbeds</p>
        </div>
        </footer>
        <script>
    let menuOpen = false;

    function confirmacion(){
            var respuesta=confirm("¿Desea cancelar la reserva?");
            if(respuesta==true){
                return true;
            }
            else{
                return false;
            }
        }

    function toggleMenu() {
        if (menuOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    }

    function openMenu() {
        document.getElementById("frame1").style.visibility = "visible";
        document.getElementById("frame1").classList.add("style");
        menuOpen = true;
    }

    function closeMenu() {
        document.getElementById("frame1").classList.remove("style");
        document.getElementById("frame1").style.visibility = "hidden";
        document.getElementById("frame2").classList.remove("style2");
        menuOpen = false;
    }

    function Setting() {
        document.getElementById("frame2").style.visibility = "visible";
        document.getElementById("frame2").classList.add("style2");
    }

    function cancelarReserva() {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "cancelar_reserva.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Aquí puedes realizar alguna acción si lo deseas
                console.log(xhr.responseText);
            }
        };
        xhr.send();
    }
</script>
</body>
</html>