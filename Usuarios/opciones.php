<?php
require '../Bd/conexion.php';
$bd=conectar_db();
session_start();
if(!isset($_SESSION['cod_usuario'])){
    header("Location: ../index.php");
}
elseif($_SESSION['cod_usuario']!=2){
    header("Location: ../index.php");
}
$id=$_SESSION['cod_usuario'];
$sql="SELECT * FROM persona WHERE cod_usuario='$id'";
$resultado=mysqli_query($bd,$sql);
$row=mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="../admin/diseño/Admin.css">
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
                <li><a href="">Habitaciones</a>
                    <ul class="submenu">
                        <li><a href="">Sencilla</a></li>
                        <li><a href="">Doble</a></li>
                        <li><a href="">Triple</a></li>
                        <li><a href="">Familiar</a></li>
                    </ul>
                </li>
            <?php if(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']!=2):?>
            <li><a href="vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="salir.php" onclick='return confirmacion()'>Salir</a></li>
                </ul>
            </li>
            <?php elseif(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']==2):?>
            <li><a href="vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="opciones.php">Opciones</a></li>
                    <li><a href="salir.php" onclick='return confirmacion()'>Salir</a></li>
                </ul>
                </li>
            <?php else :?>
            <li><a href="iniciarsesion.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="iniciarsesion.php">Iniciar sesión</a></li>
                    <li><a href="crear.php">Registrarse</a></li>
                </ul>
            </li>
            <?php endif;?>
                <li><a href="">Contáctenos</a></li>
            <li><a href="Servicios/servicios.php">Servicios</a>
            <ul class="submenu">
                <li><a href="">Piscina</a></li>
                <li><a href="">Restaurante</a></li>
                <li><a href="">Gimnasio</a></li>
                <li><a href="">Bar</a></li>
                <li><a href="">Zonas húmedas</a></li>
                </ul>
            </li>
        </ul>
        </nav>
    </header>
    <div class="contenido">
        <p>Bienvenido administrador <?php echo $row['nombres'] ." ".$row['apellidos']?></p> <!--- Se le da  una bienvenida a la persona que ingrese a la interfaz del administrador --->
        <p>Registra nuevos usuarios, habitaciones y reservas en el sistema y también gestionar los servicios del hotel y la facturación.</p><a href="https://www.sena.edu.co/es-co/sena/Paginas/quienesSomos.aspx">Nuestra pagina web</a> <!--- Actualizar para que redireccione a la pagian web del hotel--->
    </div>
    <div class="container">
        <div class="card">
            <img src="../admin/imagenes/usuarios.png" alt="">
            <h4>Usuarios</h4>
            <p>Aquí podrás gestionar a todos los usuarios del sistema, empleados, clientes etc.</p>
            <a href="verusuarios.php"><input type="button" value="Registrar"></a>
        </div>
       
        <div class="card">
            <img src="../admin/imagenes/calendario.png" alt="">
            <h4>Reservas</h4>
            <p>Aquí registras las reservas del hotel y puedes actualizarlas y eliminarlas</p>
            <a href="../admin/clases/Reserva/seleccionar.php"><input type="button" value="Registrar"></a>
        </div>

        <div class="card">
            <img src="../admin/imagenes/habitaciones.png" alt="">
            <h4>Habitaciones</h4>
            <p>Podrás registrar habitaciones nuevas, actualizarlas según su estado y también su descripción.</p>
            <a href="../admin/clases/Habitacion/seleccionar.php"><input type="button" value="Registrar"></a>
        </div>
        <div class="card">
            <img src="../admin/imagenes/restaurante.png" alt="">
            <h4>Servicios</h4>
            <p>Registrar y Consultar los servicios que van a estar disponibles dentro del hotel</p>
            <a href="../admin/clases/Servicios/seleccionar.php"><input type="button" value="Registrar"></a>
        </div>
        
        <div class="card">
            <img src="../admin/imagenes/factura.png" alt="">
            <h4>Facturas</h4>
            <p>Aquí estarán los detalles de cada factura con su respectiva política de privacidad de datos.</p>
            <a href=""><input type="button" value="Ver"></a>
        </div>
    </div> 
</body>
</html>