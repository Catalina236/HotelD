<!DOCTYPE html>
<h lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="../diseño/style.css">
    <title>Servicios</title>
</head>
<?php
    session_start();
    ?>
    <header>
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
        <nav class="menu">
        <ul class="menu-principal">
            <li><a href="../Reserva/ver_reservas.php">Reserva</a>
            <ul class="submenu">
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

    <div class="carrusel">
        <div class="atras">
            <img id="atras" src="../imagenes/atras.png" alt="atras" loading="lazy">
        </div>

        <div class="imagenes">
            <div id="img">
                <img class="img" src="../imagenes/restaurante.jpg" alt="imagen 1" loading="lazy">
            </div>
            <div class="texto" id="texto">
            </div>
        </div>
        <div class="adelante" id="adelante">
            <img src="../imagenes/hacia-adelante.png" alt="adelante" loading="lazy">
        </div>
    </div>
    
    <div class="puntos" id="puntos"></div>
    <script src="../js/app.js"></script>
    <section class="hero">
        <div class="text-content">
            <h2>Nuestros servicios</h2>
            <p>Ofrecemos una variedad de servicios en nuestro hotel que podrás disfrutar en tu estadía, como piscina, bar, entre muchos otros.
            Para mayor comodidad puedes añadirlos al carrito, pero si prefieres puedes llegar al hotel y solicitar el servicio que prefieras.
            </p>
        </div>
        <div class="image-content">
            <img class="imagen1" src="../imagenes/piscina.webp" alt="Imagen 1">
        </div>
    </section>
    <section class="features">
        <div class="feature">
            <img src="../imagenes/Bar2.jpg" alt="Salón comedor">
            <div class="feature-text">
                <h3>Bar</h3>
                <p>Disfruta de un ambiente animado, cócteles creativos hasta cervezas artesanales, nuestro bar es el lugar perfecto para relajarte y disfrutar de momentos inolvidables. ¡Te esperamos para una experiencia única!</p>
                <a href="serviciobar.php">Ver más</a>
               </div>
        </div>
        <div class="feature">
            <img src="../imagenes/restaurante.jpg" alt="Despacho">
            <div class="feature-text">
                <h3>Restaurante</h3>
                <p>Nuestro restaurante ofrece una variedad de platos cuidadosamente elaborados, opciones locales auténticas creaciones culinarias internacionales. Con un servicio atento y un ambiente acogedor, es el lugar perfecto para disfrutar de momentos culinarios inolvidables.
                </p>
                <a href="serviciores.php">Ver más</a>
            </div>
        </div>
        <div class="feature">
            <img src="../imagenes/piscina.jpg" alt="Salón comedor">
            <div class="feature-text">
                <h3>Piscina y spa</h3>
                <p>Sumérgete en un oasis de serenidad con nuestra piscina rejuvenecedora. Además, disfruta de experiencias de sauna, baño turco y jacuzzi para relajar cuerpo y mente. Nuestro Spa ofrece momentos de bienestar en un entorno tranquilo y elegante.</p>
                <a href="serviciozona.php">Ver más</a>
               </div>
        </div>
    </section>

<!--    <div class="button-container">
        <button>🏡 Visita virtual</button>
    </div>-->
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
</body>
</html>