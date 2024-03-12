<?php
require '../Bd/conexion.php';
$bd = conectar_db();

session_start();
$email=$_SESSION['correo_electronico'];

if(isset($_POST['Enviar'])){
    $code = mysqli_real_escape_string($bd,$_POST['codigo']);

    $sql = "SELECT * FROM usuarios WHERE codigo = $code";
    $resultado = mysqli_query($bd, $sql);

    if(mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $email=$fila['correo_electronico'];
        $_SESSION['correo_electronico']=$email;
        header("Location:acpass.php");
        exit();
    } else {
        $mensaje_error = "Código incorrecto";
        unset($_SESSION['info']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="../diseño/estilosi.css">
    <title>Validar Código</title>
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
                <li><a href="../Servicios/servicios.html">Servicios</a>
                    <ul class="submenu">
                        <li><a href="#">Piscina</a></li>
                        <li><a href="">Restaurante</a></li>
                        <li><a href="">Gimnasio</a></li>
                        <li><a href="">Bar</a></li>
                        <li><a href="">Zonas húmedas</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <form class="formulario" action="codigopass.php" method="post">
        <h1>Código</h1>
        <?php 
        if(isset($_SESSION['info'])){?>
            <div class="alerta-success text-center" style="padding: 0.4rem 0.4rem">
                <?php echo $_SESSION['info']; ?>
            </div>
            <?php
            }
                    ?>
    
        <?php if(isset($mensaje_error)) { ?>
            <div class="alerta text-center"><?php echo $mensaje_error; ?></div>
        <?php } ?>
        <br>
        <input class="control" type="number" name="codigo" id="" placeholder="Ingrese el código">
        <br>
        <input class="boton" type="submit" value="Enviar" name="Enviar">
    </form>
</body>
</html>