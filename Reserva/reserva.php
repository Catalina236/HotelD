<?php
require '../Bd/conexion.php';
$bd = conectar_db();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../diseño/estilo.css">
    <link rel="icon" href="../imagenes/logo.png">
    <title>Reserva</title>
</head>
<body>
    <?php
    session_start();
    ?>
    <header>
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
        <nav class="menu">
            <ul class="menu-principal">
                <li><a href="Reserva/reserva.php">Reserva</a></li>
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
                    <li><a href="../Usuarios/salir.php" onclick='return confirmacion()'>Salir</a></li>
                </ul>
            </li>
            <?php elseif(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']==2):?>
            <li><a href="vercuenta.php">Mi Perfil</a>
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
            <li><a href="Servicios/servicios.html">Servicios</a>
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
        <section class="busqueda">
            <form action="reserva.php" method="post">
                <input type="date" name="fecha_inicio" id="" class="fecha">
                <input type="date" name="fecha_fin" id="" class="fecha">
                <input type="submit" value="Buscar" class="botonb" name="filtrar">
            </form>
        </section>
        <section class="habitaciones">
            <?php
            if(isset($_POST['filtrar'])){
                $fechai = $_POST['fecha_inicio'];
                $fechaf = $_POST['fecha_fin'];
                $sql2 = "SELECT * FROM tipo_habitacion JOIN habitacion ON tipo_habitacion.cod_tipo_hab=habitacion.cod_tipo_hab LEFT OUTER JOIN reserva ON reserva.cod_tipo_hab=habitacion.cod_tipo_hab WHERE fecha_inicio<>'$fechai' AND fecha_fin<>'$fechaf' OR fecha_inicio IS NULL";
                $consulta = mysqli_query($bd, $sql2);
                while($habitacion = mysqli_fetch_assoc($consulta)){ ?>
                <div class="habitacion">
                <img src="../admin/clases/Habitacion/imagenes/<?php echo $habitacion['imagen'];?>" alt="Imagen de habitación">
                    <div class="info">
                        <h3>Habitación <?php echo $habitacion['nom_tipo_hab'];?></h3>
                        <p><?php echo $habitacion['capacidad'];?></p>
                        <h4><?php echo $habitacion['valor_base'];?></h4>
                        <h4><?php echo $habitacion['estado_hab'];?></h4>
                        <p><?php echo $habitacion['descripcion_hab'];?></p>
                        <button class="botonre"><a href="../habitaciones/confirmar_reserva.php?cod_tipo_hab=<?php echo $habitacion['cod_tipo_hab'];?>">Reservar></a></button>
                    </div>
                </div>
            <?php }
            } else {
                $sql="SELECT * FROM tipo_habitacion JOIN habitacion ON tipo_habitacion.cod_tipo_hab=habitacion.cod_tipo_hab";
                $result=mysqli_query($bd, $sql);
                while ($habitacion=mysqli_fetch_assoc($result)){
            ?>
                <div class="habitacion">
                <img class="habitaciones" src="../admin/clases/Habitacion/imagenes/<?php echo $habitacion['imagen'];?>" alt="Imagen de habitación">
                    <div class="info">
                        <h3>Habitación <?php echo $habitacion['nom_tipo_hab'];?></h3>
                        <p><?php echo $habitacion['capacidad'];?></p>
                        <h4><?php echo $habitacion['valor_base'];?></h4>
                        <h4><?php echo $habitacion['estado_hab'];?></h4>
                        <p><?php echo $habitacion['descripcion_hab'];?></p>
                        <button class="botonre"><a href="../habitaciones/confirmar_reserva.php?cod_tipo_hab=<?php echo $habitacion['cod_tipo_hab'];?>">Reservar></a></button>
                    </div>
                </div>
            <?php 
                }
            }
            ?>
        </section>
    </div>
</body>
</html>
