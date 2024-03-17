<?php
require '../Bd/conexion.php';
$bd=conectar_db();
session_start();
if ($_SERVER['REQUEST_METHOD']=='POST'){
        $pass=$_POST['contraseña'];
        $password=$_POST['contraseñav'];
    if($pass==$password){
        $Contraseña=mysqli_real_escape_string($bd,$password);
        $email=$_SESSION['correo_electronico'];
        $password_encriptada=sha1($Contraseña);
        $sql="UPDATE usuarios SET contraseña='$password_encriptada' WHERE correo_electronico='$email';";
        $resultado=mysqli_query($bd,$sql);
        if($resultado){
            echo "<script type='text/javascript'>
            alert ('Contraseña reestablecida correctamente. Ya puede ingresar con su nueva contraseña');
            window.location='iniciarsesion.php';
            </script>";
    }
    }
    else{
        $alerta="Las contraseñas no coinciden";
        //echo "<div class='alerta'></div>";
    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="../diseño/estilosi.css">
    <title>Reestablecer contraseña</title>
</head>
<body>
<header>
    <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
    <nav class="menu">
            <ul class="menu-principal">
                <li><a href="../Reserva/reserva.php">Reserva</a>
                <ul class="submenu">
                    <li><a href="">Crear reserva</a></li>
                    <li><a href="">Cancelar reserva</a></li>
                    <li><a href="">Consultar</a></li>
                </ul>
                </li>
                <li><a href="#">Habitaciones</a>
                    <ul class="submenu">
                        <li><a href="">Doble</a></li>
                        <li><a href="">Sencilla</a></li>
                        <li><a href="">Triple</a></li>
                        <li><a href="">Familiar</a></li>
                    </ul>
                </li>
                <li><a href="iniciarsesion.php">Mi perfil</a>
                <ul class="submenu">
                    <li><a href="salir.php">Salir</a></li>
                </ul>
            </li>
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
    <form class="formulario" action="acpass.php" method="post">
        <h1>Reestablecer contraseña</h1>
        <?php if(isset($alerta)) { ?>
            <div class="alerta text-center"><?php echo $alerta; ?></div>
        <?php } ?>
        <input class="control" type="password" name="contraseña" id="contraseña" placeholder="Ingrese su nueva contraseña">
        <i class="bx bx-show-alt"></i>
        <br>  
        <input class="control" type="password" name="contraseñav" id="" placeholder="Por favor verifique">
        <input class="boton" type="submit" value="Enviar" name="Enviar">
        <script src="../js/verpass.js"></script>
    </form>
</body>
</html>