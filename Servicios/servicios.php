<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="../diseño/style.css">
    <title>Servicios</title>
</head>
<body>
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
            <!--<img class="imagen2" src="../imagenes/spa2.jpg" alt="Imagen 2">-->
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
</body>
</html>

</body>
</html>
<style>
/*        
@import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@500&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap');

body{
    height: 70vh;
    background-color: rgb(245,245,245);
    font-family: 'Nunito', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding-top: 70px;
}
.atras img{
    width: 34px;
}
.adelante img{
    width: 34px;
}
.atras:hover img{
    cursor: pointer;
}
.adelante:hover img{
    cursor: pointer;
}
.carrusel{
    display: flex;
    align-items: center;    
    justify-content: center;
    overflow: hidden;
    width: 100%;
    height: 60vh;
}
.imagenes{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: end;
}
.img{
    box-shadow: 0px 4px 10px 0px rgba(0,0,0,0.85);
    height: 476px;
    width: 1050px;
    border-radius: 15px;
    margin: 5px;
    object-fit: cover;
    filter: saturate(175%);
}
.texto{
    overflow: hidden;
    position:absolute;
    flex-direction: column;
    transform: translateY(0px);
    margin-bottom: 9px;
    backdrop-filter: blur(20px);
    background-color: rgba(63,106,138,0.21);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 30px;
}
.texto h3{
    text-shadow: 0px 0px 15px black;
    padding-top: 4px;
    color: white;
    font-weight: 300;
    font-size: 27px;
}
.texto p{
    align-items:center;
    padding: 20px;
    color: white;
    font-size: 0px;
    font-weight: 300;
}
.imagenes .texto{
    width: 600px;
    height: 100px;
    transition: 1s;
}
.imagenes:hover .texto{
    transition: height 1s, transform 1s, background-color 1s;
    transform: translateY(-40px);
    height: 410px;
    background-color: rgba(63,106,138,0.71);
}
.imagenes:hover .texto p{
    transition: font-size 0s .2s linear;
    font-size: 23px;
    font-weight: 300;
    text-shadow: 0px 0px 10px #0000;
}
.puntos{
    display: flex;
    margin-top: -64px;
    align-items: center;
    justify-content: center;
}
.puntos p{
    font-size: 100px;
    font-weight:500;
    margin-top: -10px;
    color: black;
}
.puntos .bold{
    font-weight: 600;
    margin-left:3px;
    margin-right:3px;
    color:dodgerblue;
}*/
</style>
</body>
</html>