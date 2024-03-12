<?php
require '../Bd/conexion.php';

$bd=conectar_db();
session_start();
if(!isset($_SESSION['cod_usuario'])){
    header("Location:../index.php");
}
else{
    if($_SESSION['cod_usuario']!=2){
        header("Location:../index.php");
    }
}
$errores=[];

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $Documento=$_POST['num_doc'];
    $TipoDocumento=$_POST['tipo_doc'];
    $Nombre=$_POST['nombres'];
    $Apellido=$_POST['apellidos'];
    $Email=$_POST['email'];
    $Contraseña=$_POST['contraseña'];
    $Telefono=$_POST['telefono'];
    $Direccion=$_POST['direccion'];
    $Foto=$_FILES['foto']['name'];
    $Tipo_usuario=$_POST['nombre_tipo'];


    if(!$Documento){
        $errores[]='El número de documento es obligatorio';
    }
    if(!$TipoDocumento){
        $errores[]= 'El tipo de documento es obligatorio';
    }
    if(!$Nombre){
        $errores[]='El nombre es obligatorio';
    }
    if(!$Apellido){
        $errores[]='El apellido es obligatorio';
    }
    if(!$Email){
        $errores[]='El correo electrónico es obligatorio';
    }
    if(!$Contraseña){
        $errores[]='La contraseña es obligatoria.';
    }
    if (!$Tipo_usuario){
        $errores[]='El tipo de usuario es obligatorio.';
    }
    if(empty($errores)){
        $sqlv="SELECT * FROM usuarios JOIN persona ON usuarios.correo_electronico=persona.correo_electronico WHERE usuarios.correo_electronico='$Email' OR num_doc='$Documento'";
        $usuario=mysqli_query($bd,$sqlv);

        if($usuario){
            echo '<center><h3 class="mensaje">El usuario ya se encuentra registrado</h3></center>';
        }    
        
        if(isset($Foto)&&$Foto!=""){
            $tipo=$_FILES['foto']['type'];
            $temp=$_FILES['foto']['tmp_name'];

            $Password=mysqli_real_escape_string($bd,$Contraseña);
            $password_encriptada=sha1($Password);

            $sql="INSERT INTO usuarios (correo_electronico, contraseña, foto) VALUES('$Email','$password_encriptada','$Foto')";
            $sql3="INSERT INTO persona VALUES ('$Documento','$TipoDocumento','$Nombre','$Apellido','$Email','$Telefono','$Direccion','$Tipo_usuario')";

            $resultado=mysqli_query($bd,$sql);
            //$resultado=mysqli_query($bd,$sql2);
            $resultado=mysqli_query($bd,$sql3);

            if($resultado){
                move_uploaded_file($temp, 'imagenesbd/'.$Foto);
                header('location: ../index.php');
            }
        }
            else{
                foreach($errores as $error){
                    echo '<br>' .$error;
                }
            }
            }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../diseño/estilosform.css">
    <title>Registro</title>
</head>
<body>
<?php
//    session_start();
?>
    <header>
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
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
                <script>
                    function confirmacion(){
                        var respuesta=confirm('¿Seguro desea salir?');
                        if(respuesta==true){
                            return ture;
                        }
                        else{
                            return false;
                        }
                    }
                </script>
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
            <li><a href="Servicios/servicios.php">Servicios</a>
            <ul class="submenu">
                <li><a href="">Piscina</a></li>
                <li><a href="">Restaurante</a></li>
                <li><a href="">Gimnasio</a></li>
                <li><a href="">Bar</a></li>
                <li><a href="">Zonas húmedas</a></li>
                </ul>
            </li>
        </ul>
        </nav>
    </header>
    <div class="contenido">
        <form class="formulario" method="POST" action="crear.php" enctype="multipart/form-data">
            <h1>Registro persona</h1>
        <fieldset>
            <input class ="control" type="text" name="num_doc" id="Documento" placeholder="Ingrese su número de documento">
            <select class="control" name="tipo_doc" id="tipo_doc">
                <option value="">Tipo de documento</option>
                <option value="Cédula de ciudadanía">Cédula de ciudadanía</option>
                <option value="Cédula de extranjería">Cédula de extranjería</option>
                <option value="Pasaporte">Pasaporte</option>
            </select>
            <input class ="control" type="text" name="nombres" id="Nombre" placeholder="Ingrese su(s) nombre(s)">
            <input class ="control" type="text" name="apellidos" id="Apellido" placeholder="Ingrese su(s) apellido(s)">
            <input class="control" type="email" name="email" id="email" placeholder="Ingrese su correo electrónico">
            <input class="control" type="password" name="contraseña" id="contraseña" placeholder="Ingrese una contraseña">
            <input class="control" type="text" name="telefono" id="telefono" placeholder="Ingrese su número teléfonico">
            <input class="control" type="text" name="direccion" id="direccion" placeholder="Ingrese su dirección">
            <select class="control" name="nombre_tipo" id="nombre_tipo">
                <option value="">Seleccione su tipo de usuario</option>
                <option value="Cliente">Cliente</option>
                <option value="Empleado">Empleado</option>
            </select>
            <input type="file" name="foto" id="">
            <input class ="boton" type="submit" id="Enviar" name="Enviar" value="Enviar">
        </fieldset>
    </form>
    </div>
</body>
</html>