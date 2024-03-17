<?php
require '../Bd/conexion.php';

$bd=conectar_db();

// Extraer el dominio de correo electrónico
session_start();
//if(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']==2)
if(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']!=2){
    header("Location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="../diseño/estilosform.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Registro</title>
</head>
<body>
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
            <?php elseif(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']==2):?>
            <li><a href="vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="opciones.php">Opciones</a></li>
                    <li><a href="salir.php" onclick='return confirmacion()'>Salir</a></li>
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
        <form class="formulario" method="POST" action="crear.php" enctype="multipart/form-data">
            <h1>Registro persona</h1>
            
<?php
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
    
    if(empty($errores)){
        //$email = 'usuario@example.com';

        // Extraer el dominio de correo electrónico
        $domain = substr(strrchr($Email, "@"), 1);

        // Verificar si el dominio termina en ".com"
        if (substr($domain, -4) === ".com" || ".es") {
            //echo "El dominio del correo electrónico termina en '.com'.";
            $sqlv="SELECT * FROM usuarios JOIN persona ON usuarios.correo_electronico=persona.correo_electronico WHERE usuarios.correo_electronico='$Email' OR num_doc='$Documento'";
            $usuario=mysqli_query($bd,$sqlv);
        
        if($usuario){
            echo '<div class="alerta">El usuario ya se encuentra registrado</div>';
        }    

        if(isset($Foto)){
            $tipo=$_FILES['foto']['type'];
            $temp=$_FILES['foto']['tmp_name'];

            $Password=mysqli_real_escape_string($bd,$Contraseña);
            $password_encriptada=sha1($Password);

            $sql="INSERT INTO usuarios (correo_electronico, contraseña, foto) VALUES('$Email','$password_encriptada','$Foto')";
            $sql3="INSERT INTO persona VALUES ('$Documento','$TipoDocumento','$Nombre','$Apellido','$Email','$Telefono','$Direccion',1)";

            $resultado=mysqli_query($bd,$sql);
            $resultado=mysqli_query($bd,$sql3);

            if($resultado){
                move_uploaded_file($temp, 'imagenesbd/'.$Foto);
                echo "<script type='text/javascript'>
			    alert ('Usuario registrado exitosamente...');
                window.location='../index.php';
                </script>";
            }
        }
            else{
                foreach($errores as $error){
                    echo '<br>' .$error;
                }
            }
            }
            else {
                echo '<div class="alerta">El correo ingresado no es válido</div>';
        }
        }
    }
?>
        <fieldset>
            <input class ="control" type="text" name="num_doc" id="Documento" placeholder="Ingrese su número de documento" required>
            <select class="control" name="tipo_doc" id="tipo_doc" required>
                <option value="">Tipo de documento</option>
                <option value="Cédula de ciudadanía">Cédula de ciudadanía</option>
                <option value="Cédula de extranjería">Cédula de extranjería</option>
                <option value="Pasaporte">Pasaporte</option>
            </select>
            <input class ="control" type="text" name="nombres" id="Nombre" placeholder="Ingrese su(s) nombre(s)" required>
            <input class ="control" type="text" name="apellidos" id="Apellido" placeholder="Ingrese su(s) apellido(s)" required>
            <input class="control" type="email" name="email" id="email" placeholder="Ingrese su correo electrónico">
            <input class="control" type="password" name="contraseña" id="contraseña" placeholder="Ingrese una contraseña" required>
            <i class="bx bx-show-alt"></i>
            <input class="control" type="text" name="telefono" id="telefono" placeholder="Ingrese su número teléfonico" required>
            <input class="control" type="text" name="direccion" id="direccion" placeholder="Ingrese su dirección" required>
            <?php if(!isset($_SESSION['cod_usuario']) || $_SESSION['cod_usuario']!=2):?>
            <?php else:?>
            <div class="contenido-oculto">
            <select class="control" name="nombre_tipo" id="nombre_tipo">
                <option value="">Seleccione su tipo de usuario</option>
                <option value="Cliente">Cliente</option>
                <option value="Empleado">Empleado</option>
            </select>
            </div>
            <?php endif;?>
            <br>
            <input class="archivo" type="file" name="foto" id="">
            <br>
            <input class ="boton" type="submit" id="Enviar" name="Enviar" value="Enviar">
        </fieldset>
    </form>
    </div>
    <script src="../js/verpass.js"></script>
</body>
</html>