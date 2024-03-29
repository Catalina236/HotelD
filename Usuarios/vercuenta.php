<?php
require '../Bd/conexion.php';
$bd=conectar_db();
session_start();
if (!isset($_SESSION['correo_electronico'])){
    header("Location:../index.php");
}

$iduser=$_SESSION['correo_electronico'];
$sql="SELECT * FROM usuarios JOIN persona ON usuarios.correo_electronico=persona.correo_electronico WHERE usuarios.correo_electronico='$iduser'";
$resultado=$bd->query($sql);
$row=$resultado->fetch_assoc();

if ($row['foto'] != null) {
    $foto = "imagenesbd/" . $row['foto'];
} else {
    // Si la foto está nula o no se encuentra, usar una imagen predeterminada
    $foto = "imagenesbd/usuario.png";
}
//$foto="imagenesbd/". $row['foto'];
//$fotov="imagenesbd/usuario.png";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="../diseño/estilosform.css">
    <title>Cuenta</title>
</head>
<body>
<header>
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
        <nav class="menu">
            <ul class="menu-principal">
            <li><a href="../Reserva/reserva.php">Reserva</a>
                    <ul class="submenu">
                        <li><a href="../Reserva/ver_reservas.php">Ver reservas</a></li>
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
        <div class="head">
        </div>
        <div class="container">
            <form action="" class="formulario">
                <fieldset id="datos_usuario">
                <h2>Mi Perfil</h2>
            <?php if($foto!=null):?>
                <div class="foto-p">
                    <span class="foto-perfil">
                        <img class="avatar" src="<?php echo $foto;?>" alt="">
                    </span>
                    </div>
            <br>
            <?php else:?>
                    <div class="foto-p">
                    <span class="foto-perfil">
                        <img class="avatar" src="<?php echo $foto;?>" alt="">
                    </span>
                    </div>
            <br>
            <?php endif; ?>
            <span class="datos"><?php echo($row['nombres'] ." ".$row['apellidos']);?></span>
            <br>
            <span class="datos"><?php echo($row['correo_electronico']);?></span>
            <br>
            <span class="datos"><?php echo($row['telefono']);?></span>
            <br>
            <span class="datos"><?php echo($row['direccion']);?></span>
            <br>
            <span class="datos"><?php echo($row['tipo_doc']);?></span>
            <br>
            <span><a href="actualizar.php?correo_electronico=<?php echo $row['correo_electronico'];?>">Editar</a></span>
            </fieldset>
            </form>
        </div>
    </div>
    <script>
        function salir(){
            var respuesta=confirm("¿Seguro desea salir?");
            if(respuesta==true){
                return true;
            }
            else{
                return false;
            }
        }
    </script>
</body>
</html>