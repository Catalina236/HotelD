<?php
require '../Bd/conexion.php';
$conn=conectar_db();
session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../diseño/estilosi.css">
    <link rel="icon" href="../imagenes/logo.png">
    <title>Recuperar Contraseña</title>
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
    <div class="container">
        <form class="formulario" method="POST" action="recuperarpass.php">            
            <h1>Recuperar contraseña</h1>
            <fieldset>
            <?php
            if(isset($_POST['Enviar'])){
                $email=mysqli_real_escape_string($conn,$_POST['email']);
                $sql="SELECT * FROM usuarios WHERE correo_electronico='$email'";
                $resultado=mysqli_query($conn,$sql);
            
            
            if(mysqli_num_rows($resultado)>0){
                $codigo_verificacion=generarCodigo();
                $sql="UPDATE usuarios SET codigo='$codigo_verificacion' WHERE correo_electronico='$email'";
                $conn->query($sql);
            
                $mensaje = "Hola,\n\nPara restablecer tu contraseña, utiliza el siguiente código de verificación:\n\n";
                $mensaje .= $codigo_verificacion;
                $mensaje .= "\n\nSaludos,\nTu Sitio Web";
            
                $envio=mail($email, "Código restablecer contraseña: ",$mensaje);
                if($envio){
                    $info="Ingresa el código que enviamos a tu email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['correo_electronico'] = $email;
                    header('location: codigopass.php');
                    exit();
                }
                else
                {
                    echo "<div class='alerta'>Ocurrió un problema al momento de enviar el correo</div>";
                }
            }else{
                echo "<div class='alerta'>No se encontró ningún correo que coincida</div>";
            }
            }
            function generarCodigo(){
                return rand(100000,999999);
            }
            ?>
                <input class="control" type="email" name="email" id="email" placeholder="Ingrese su correo electrónico" required>
                <input class="boton" name="Enviar" type="submit" value="Continuar">
            </fieldset>
        </form>
    </div>
</body>
</html>