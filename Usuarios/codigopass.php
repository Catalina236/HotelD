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
            <li><a href="../Reserva/ver_reservas.php">Reserva</a>
            <ul class="submenu">
            </ul>
                </li>
                <li><a href="../Habitaciones/habitaciones.php">Habitaciones</a></li>
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