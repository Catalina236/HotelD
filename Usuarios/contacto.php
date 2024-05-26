<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="../diseño/contacto.css">
    <title>Contacto</title>
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
            <li><a href="../habitaciones/habitaciones.php">Habitaciones</a>
                    <ul class="submenu">
                    </ul>
                </li>
            <?php if(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']!=2):?>
            <li><a href="vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="salir.php" onclick='return salir()'>Salir</a></li>
                </ul>
            </li>
            <?php elseif(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']==2):?>
            <li><a href="vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="opciones.php">Opciones</a></li>
                    <li><a href="salir.php" onclick='return salir()'>Salir</a></li>
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
    <div class="ver_datos">
        <h1>Contáctate con nosotros</h1>
        <i class="fa-solid fa-phone"></i><p>3222222222222</p>
        <i class="fa-solid fa-envelope"></i><p>hotelauroraoasis12@gmail.com</p>
        <i class="fa-solid fa-location-dot"></i><p>Soacha, Cundinamarca</p>
    </div>
    <div class="datos_usuario">
        <form action="contacto.php" method="post">
            <input type="text" placeholder="Nombre" name="nombre">
            <input type="email" placeholder="Email" name="email">
            <textarea name="mensaje" id="" cols="30" rows="5"></textarea>
            <input type="submit" value="Enviar" name="Enviar_datos">
        </form>
    </div>
    </div>
</body>
</html>