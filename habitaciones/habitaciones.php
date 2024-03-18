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
    <title>Habitaciones</title>
</head>
<body>
    <?php
    session_start();
    ?>
    <header>
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
        <nav class="menu">
            <ul class="menu-principal">
            <li><a href="../Reserva/reserva.php">Reserva</a>
                    <ul class="submenu">
                        <li><a href="../Reserva/ver_reservas.php">Ver reservas</a></li>
                    </ul>
            </li>
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
        <section class="busqueda">
            <form action="habitaciones.php" method="post">
                <input type="date" name="fecha_inicio" id="" class="fecha" value="<?php if(isset($_POST['fecha_inicio'])) echo $_POST['fecha_inicio']; ?>">
                <input type="date" name="fecha_fin" id="" class="fecha" value="<?php if(isset($_POST['fecha_fin'])) echo $_POST['fecha_fin']; ?>">
                <input type="submit" value="Buscar" class="botonb" name="filtrar">
            </form>
        </section>
        <section class="habitaciones">
            <?php
            if(isset($_POST['filtrar'])){
                //$capacidad=$_POST['capacidad'];
                //$tipo=$_POST['tipo_hab'];
                $fechai = $_POST['fecha_inicio'];
                $fechaf = $_POST['fecha_fin'];

                $sql2 = "SELECT *, tipo_habitacion.cod_tipo_hab
                FROM tipo_habitacion
                JOIN habitacion ON tipo_habitacion.cod_tipo_hab = habitacion.cod_tipo_hab
                LEFT JOIN reserva ON tipo_habitacion.cod_tipo_hab = reserva.cod_tipo_hab
                AND (fecha_fin >= '$fechai' AND fecha_inicio <= '$fechaf')
                WHERE reserva.cod_tipo_hab IS NULL";

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
                        <button class="botonre"><a href="../Reserva/confirmar_reserva.php?cod_tipo_hab=<?php echo $habitacion['cod_tipo_hab'];?>">Reservar</a></button>
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
                        <button class="botonre"><a href="../Reserva/confirmar_reserva.php?cod_tipo_hab=<?php echo $habitacion['cod_tipo_hab'];?>">Reservar</a></button>
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
