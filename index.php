<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="diseño/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="icon" href="imagenes/logo.png">
    <script src="js/code.jquery.com_jquery-3.7.1.min.js"></script>
    <title>Inicio</title>
</head>
<body>
    <?php
    session_start();
    ?>
    <header>
        <a href="index.php"><img src="imagenes/logo.png" alt="" class="logo"></a>
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
            <li><a href="Usuarios/vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="Usuarios/salir.php" onclick='return confirmacion()'>Salir</a></li>
                </ul>
            </li>
            <?php elseif(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']==2):?>
            <li><a href="Usuarios/vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="Usuarios/opciones.php">Opciones</a></li>
                    <li><a href="Usuarios/salir.php" onclick='return confirmacion()'>Salir</a></li>
                </ul>
                </li>
            <?php else :?>
            <li><a href="Usuarios/iniciarsesion.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="Usuarios/iniciarsesion.php">Iniciar sesión</a></li>
                    <li><a href="Usuarios/crear.php">Registrarse</a></li>
                </ul>
            </li>
            <?php endif;?>
                <li><a href="">Contáctenos</a></li>
            <li><a href="Servicios/servicios.html">Servicios</a>
            <ul class="submenu">
                <li><a href="">Restaurante</a></li>
                <li><a href="">Bar</a></li>
                <li><a href="">Zonas húmedas</a></li>
                </ul>
            </li>
        </ul>
        </nav>
    </header>
    <script>
            function confirmacion(){
                        var respuesta=confirm('¿Seguro desea salir?');
                        if(respuesta==true){
                            return true;
                        }
                        else{
                            return false;
                        }
                    }
                </script>
    <div class="contenido">
        <section id="bloque-inicio" class="inicio">
            <div class="contenedor">
                <header>
                    <h1>Hotel Aurora Oasis</h1>
                    <h2>Tus vacaciones perfectas en nuestro hotel</h2>
                </header>
                <div class="fecha">
                    <input class="casilla" type="date" name="" id="">
                    <input class="casilla" type="date" name="" id="">
                    <input class="boton" type="submit" value="Verificar">
                </div>
            </div>
        </section>
        
            <div id="banner">
                <h1>DISFRUTE DE SU ESTADÍA EN NUESTRAS CÓMODAS HABITACIONES</h1>
                <br>
                <div id="contenedor-banner" class="contenedor-banner">
                    <div id="caja" class="caja">
                        <section class="section_caja"><img src="imagenes/Hotel.jpg" class="img_caja"></section>
                        <section class="section_caja"><img src="imagenes/habitacion.jpg" class="img_caja"></section>
                        <section class="section_caja"><img src="imagenes/Habitación.jpg" class="img_caja"></section>
                        </div>
                </div>
            
                <div id="btn_atras" class="btn_atras">&#60;</div>
        
                <div id="btn_siguiente" class="btn_siguiente">&#62;</div>
            </div>
            <script src="Js/baner.js"></script>

        <section class="servicios">
            <h1>NUESTROS SERVICIOS</h1>
            <div class="contenedor_imagenes">
                <div class="item servicio1">
                    <img src="imagenes/images.jpg" alt="">
                    <div class="cont">
                        <h2 class="tpisicina">Piscina</h2>
                        <button><a href="piscina.html">Ver más</a></button>
                    </div>
                </div>
                <div class="item servicio2">
                    <img src="imagenes/Bar2.jpg" alt="">
                    <div class="cont">
                        <h2 class="tbar">Bar</h2>
                        <button><a href="Servicios/serviciobar.php">Ver más</a></button>
                    </div>
                </div>
                <div class="item servicio3">
                    <img src="imagenes/restaurante.jpg" alt="">
                    <div class="cont">
                        <h2 class="trestaurante">Restaurante</h2>
                        <button><a href="">Ver más</a></button>
                    </div>
                </div>
                <div class="item servicio4">
                    <img src="imagenes/spa3.png" alt="">
                    <div class="cont">
                        <h2 class="tspa">Spa</h2>
                        <button><a href="">Ver más</a></button>
                    </div>
            </div>
            </div>
        </div>
    </section>
    <section class="final">
        <div class="content-final">
            <h2>El lugar perfecto para perderse y desconectar</h2>
        </div>
    </section>
    
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