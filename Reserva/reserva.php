<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="../diseño/estilosform.css">
    <title>Reserva</title>
</head>
<body>
<header>
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
        <nav class="menu">
            <ul class="menu-principal">
            <li><a href="reserva.php">Reservas</a>
                    <ul class="submenu">
                        <li><a href="ver_reservas.php">Ver reservas</a></li>
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
    <div class="busqueda">
        <div class="formulario">
            <form action="../Habitaciones/habitaciones.php" method="post">
                <h1>Detalles de reserva</h1>
                <input type="date" class="control" name="fecha_inicio">
                <input type="date" class="control" name="fecha_fin">
                <input type="checkbox" name="" id=""><label for="">Todavía no he decidido las fechas</label>
                <br>
                <br>
                <input type="number" name="capacidad" id="" class="control" placeholder="Número de huéspedes">
                <input type="text" name="tipo_hab" id="tipo_hab" class="control" placeholder="Tipo de habitación">
                <input class="boton" type="submit" value="Enviar" name="filtrar">
            </form>
        </div>
    </div>
</body>
</html>