<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../diseño/estilosi.css">
    <link rel="icon" href="../imagenes/logo.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Iniciar sesión</title>
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
                <li><a href="../Habitaciones/habitaciones.php">Habitaciones</a></li>
                <li><a href="iniciarsesion.php">Mi perfil</a>
                <ul class="submenu">
                    <li><a href="crear.php">Registrarse</a></li>
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

    <div class="contenido">
        <div class="head">
        </div>
        <div class="container">
        <form class="formulario" method="POST" action="iniciarsesion.php">
            <h1>Iniciar sesión</h1>
        <fieldset>
<?php
    require '../Bd/conexion.php';
    $conn=conectar_db();
    session_start();
    if (isset($_SESSION['cod_usuario']) && isset($_SESSION['correo_electronico'])) {
        header("Location:vercuenta.php");
    }
    
    if(!empty($_POST)){
        $Email=$_POST['email'];
        $Contraseña=$_POST['contraseña'];
    
        $usuario=mysqli_real_escape_string($conn,$Email);
        $password=mysqli_real_escape_string($conn, $Contraseña);
        $password_encriptada=sha1($password);
        $sql="SELECT * FROM usuarios JOIN persona ON usuarios.correo_electronico=persona.correo_electronico WHERE usuarios.correo_electronico='$usuario' AND contraseña='$password_encriptada'";
        $resultado=mysqli_query($conn,$sql);
        $rows=mysqli_fetch_assoc($resultado);
        if ($rows>0){
            $_SESSION['correo_electronico']=$rows['correo_electronico'];
            $rol=$rows['cod_usuario'];
            $_SESSION['cod_usuario']=$rol;
            switch($_SESSION['cod_usuario']){
                case 1:
                    header("Location: vercuenta.php");
                    break;
                case 2:
                    header("Location: opciones.php");
                break;
                default:
            }
        }
        else{
            echo "<div class='alerta text-center'>Correo electrónico o contraseña incorrectos</div>";
        }
    }
?>
            <input class="control" type="email" name="email" id="email" placeholder="Ingrese su correo electrónico" required>
            <input class="control" type="password" name="contraseña" id="contraseña" placeholder="Ingrese una contraseña" required>
            <i class="bx bx-show-alt"></i>
            <input type="submit" value="Ingresar" name="Enviar" class="boton">
            <p>¿No tienes cuenta? <a class="ir_crear" href="crear.php">Crear cuenta</a></p>
            <a href="recuperarpass.php" class="restablecer">¿Olvidaste tu contraseña?</a>
        </fieldset>
    </form>
    </div>
    </div>
    <script src="../js/verpass.js"></script>
</body>
</html>