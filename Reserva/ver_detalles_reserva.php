<?php
require '../Bd/conexion.php';
$bd=conectar_db();
session_start();
if(!isset($_SESSION['correo_electronico'])){  
    echo "<script type='text/javascript'>alert('Para ver sus reservas, debe iniciar sesión');
    window.location='../Usuarios/iniciarsesion.php';
    </script>";
}
$email=$_SESSION['correo_electronico'];
$codigor=$_GET['cod_reserva'];
$sql="SELECT * FROM persona WHERE correo_electronico='$email'";
$result=mysqli_query($bd,$sql);
$datos=mysqli_fetch_assoc($result);
$num=$datos['num_doc'];
$sql1="SELECT * FROM reserva JOIN habitacion ON reserva.cod_tipo_hab=habitacion.cod_tipo_hab JOIN tipo_habitacion ON tipo_habitacion.cod_tipo_hab=habitacion.cod_tipo_hab WHERE reserva.cod_reserva='$codigor'";
$resultado=mysqli_query($bd,$sql1);
$reservas=mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="../diseño/estilo.css">
    <title>Detalles de reserva</title>
</head>
<body>
<header>
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
        <nav class="menu">
            <ul class="menu-principal">
            <li><a href="../Reserva/ver_reservas.php">Reserva</a>
            <ul class="submenu">
            </ul>
                <li><a href="../habitaciones/habitaciones.php">Habitaciones</a>
                </li>
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
            <li><a href="../Servicios/servicios.php">Servicios</a>
                <ul class="submenu">
                    <li><a href="../Servicios/serviciores.php">Restaurante</a></li>
                    <li><a href="../Servicios/serviciobar.php">Bar</a></li>
                    <li><a href="../Servicios/serviciozona.php">Zonas húmedas</a></li>
                </ul>
            </li>
    </ul>
    </nav>
    </header>
    <div class="contenido">
    <h1>Detalles de reserva</h1>
    <br>
    <?php
    if(isset($reservas)){ ?>
    <div class="detalles">
    <img src="../admin/clases/Habitacion/imagenes/<?php echo $reservas['imagen'];?>" alt="">
    <h4>Habitación <?php echo $reservas['nom_tipo_hab'];?></h4>
    <h5>Precio noche: COP <?php echo $reservas['precio'];?></h5>
    <span><?php echo $reservas['fecha_inicio'];?></span>
    <span><?php echo $reservas['fecha_fin'];?></span>
    <br>
    <span>Capacidad: <?php echo $reservas['capacidad'];?></span>
    <br>
    <span>Descripción: <?php echo $reservas['descripcion_hab'];?></span>
    <br>
    <button><a href="../factura/consulta_factura.php?cod_reserva=<?php echo $reservas['cod_reserva'];?>">Ver factura</a></button>
    <button onclick="return confirmacion()"><a href="cancelar_reserva.php?cod_reserva=<?php echo $reservas['cod_reserva'];?>">Cancelar</a></button>
</div>
<?php }?>
    </div>
    <footer class="piepag">
         <section class="informacion">
            <h3>Ubicación</h3>
            <p>Soacha Cundinamarca
            <p>Calle 30</p></section>
        
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
            function confirmacion(){
            var respuesta=confirm("¿Desea cancelar la reserva?");
            if(respuesta==true){
                return true;
            }
            else{
                return false;
            }
        }
        </script>
</body>
</html>