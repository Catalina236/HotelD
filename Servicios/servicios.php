<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../diseño/estilo.css">
    <link rel="icon" href="../imagenes/logo.png">
    <title>Servicios</title>
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
        <br>
        <br>
        <section class="serviciosl">
            <div class="serviciosa 1">
                <img class="serviciosi" src="../imagenes/restaurant.jpeg" alt="">
                <div class="info">
                    <h3>Restaurante</h3>
                    <p class="p1">¡Bienvenido al restaurante Gloria en Oasis! Sumérgete en una experiencia gastronómica excepcional donde la elegancia se encuentra con los sabores exquisitos. Nuestro espacio sofisticado ofrece una variedad de platos cuidadosamente elaborados, desde opciones locales auténticas hasta creaciones culinarias internacionales. Con un servicio atento y un ambiente acogedor, es el lugar perfecto para disfrutar de momentos culinarios inolvidables.</p>
                    <button class="botons"><a href="../Servicios/serviciores.php">Ver Menú de Restaurante</a></button>
                </div>
            </div>
            <div class="serviciosa 2">
                <img class="serviciosi" src="../imagenes/bar.jpg" alt="">
                <div class="info">
                    <h3>Bar</h3>
                    <p>¡Bienvenido al Bar Gloria en Oasis! Disfruta de un ambiente animado, cócteles innovadores y la mejor compañía. Desde cócteles creativos hasta cervezas artesanales, nuestro bar es el lugar perfecto para relajarte y disfrutar de momentos inolvidables. ¡Te esperamos para una experiencia única en el Bar Gloria</p>
                    <button class="botons"><a href="../Servicios/serviciobar.php">Ver Tipos de Bebidas</a></button>
                </div>
                
            </div>
            <div class="serviciosa 3">
                <img class="serviciosi" src="../imagenes/piscina (1).jpg" alt="">
                <div class="info">
                    <h3>Zonas Húmedas</h3>
                    <p>¡Te damos la bienvenida al Spa en Oasis! Sumérgete en un oasis de serenidad con nuestra piscina rejuvenecedora. Además, disfruta de experiencias de sauna, baño turco y jacuzzi para relajar cuerpo y mente. Nuestro Spa ofrece momentos de bienestar en un entorno tranquilo y elegante. ¡Descubre el lujo del descanso en Oasis</p>
                    <button class="botons"><a href="../Servicios/serviciozona.php">Ver Zonas Humedas</a></button>
                </div>
            </div>
            <br>
        </section>
    </div>
</body>
</html>
