<?php 
require '../Bd/conexion.php';
session_start();
if(!isset($_SESSION['cod_usuario'])){
    header("Location:../index.php");
}
$errores=[];
$codigo2=$_GET['correo_electronico'];
$codigo2 = filter_var($codigo2, FILTER_SANITIZE_EMAIL);
$bd = conectar_db();

$consulta_usuario="SELECT * FROM usuarios JOIN persona ON usuarios.correo_electronico=persona.correo_electronico WHERE persona.correo_electronico='$codigo2'";
$resultado=mysqli_query($bd, $consulta_usuario);
$usuario = mysqli_fetch_assoc($resultado);
$Documento=$usuario['num_doc'];
$TipoDocumento=$usuario['tipo_doc'];
$Nombre=$usuario['nombres'];
$Apellido=$usuario['apellidos'];
$Email=$usuario['correo_electronico'];
$Contraseña=$usuario['contraseña'];
$Telefono=$usuario['telefono'];
$Direccion=$usuario['direccion'];
$TipoPersona=$usuario['cod_usuario'];
$FotoActual = $usuario['foto'];
if ($usuario['foto'] != null) {
    $FotoB = "imagenesbd/" . $usuario['foto'];
} else {
    // Si la foto está nula o no se encuentra, usar una imagen predeterminada
    $FotoB = "imagenesbd/usuario.png";
}

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $Documento=$_POST['num_doc'];
    $TipoDocumento=$_POST['tipo_doc'];
    $Nombre=$_POST['nombres'];
    $Apellido=$_POST['apellidos'];
    $Email=$_POST['email'];
    $Contraseña=$_POST['contraseña'];
    $Telefono=$_POST['telefono'];
    $Direccion=$_POST['direccion'];
    $TipoPersona=$_POST['cod_usuario'];
    //$Foto=$_FILES['foto']['name'];
    if(empty($errores)){
        
        if(isset($_POST['contraseña'])&&!empty($_POST['contraseña'])){

            $Password=mysqli_real_escape_string($bd,$Contraseña);
            $password_encriptada=sha1($Password);
        }
        else{
            $password_encriptada=$usuario['contraseña'];
        }
        if (!empty($_FILES['foto']['name'])) {
            $Foto = $_FILES['foto']['name'];
            $tipo = $_FILES['foto']['type'];
            $temp = $_FILES['foto']['tmp_name'];
        } else {
            $Foto = $FotoActual;
        }
        }      
            
        if ($_SESSION['cod_usuario']==2){
            $sql="UPDATE usuarios SET 
            correo_electronico='$Email',
            contraseña='$password_encriptada',
            foto='$Foto'
            WHERE correo_electronico='$codigo2';";
        
            $sql2 = "UPDATE persona SET 
            num_doc = '$Documento',
            tipo_doc = '$TipoDocumento',
            nombres = '$Nombre',
            apellidos = '$Apellido',
            correo_electronico = '$Email',
            telefono='$Telefono',
            direccion='$Direccion',
            cod_usuario='$TipoPersona'
            WHERE correo_electronico = '$codigo2'";

            $resultado = mysqli_query($bd, $sql);
            $resultado = mysqli_query($bd, $sql2);

            if($resultado){
                if (!empty($_FILES['foto']['name'])) {
                move_uploaded_file($temp, 'imagenesbd/' . $Foto);
                }
                echo "<script type='text/javascript'>
                alert ('Usuario actualizado exitosamente...');
                window.location='verusuarios.php';
                </script>";
            }
            }   
            else{
                $sql="UPDATE usuarios SET
                contraseña='$password_encriptada',
                foto='$Foto'
                WHERE correo_electronico='$codigo2';";
            
                $sql2 = "UPDATE persona SET 
                nombres = '$Nombre',
                apellidos = '$Apellido',
                telefono='$Telefono',
                direccion='$Direccion'
                WHERE correo_electronico = '$codigo2'";
        
                $resultado = mysqli_query($bd, $sql);
                $resultado = mysqli_query($bd, $sql2);
        
                if($resultado){

                    if (!empty($_FILES['foto']['name'])) {
                        move_uploaded_file($temp, 'imagenesbd/' . $Foto);
                        }
                        echo "<script type='text/javascript'>
                        alert ('Usuario actualizado exitosamente...');
                        window.location='verusuarios.php';
                        </script>";
                    /*move_uploaded_file($temp, 'imagenesbd/'.$Foto);
                    /*echo "<script type='text/javascript'>
                    alert ('Usuario actualizado exitosamente...');
                    window.location='vercuenta.php';
                    </script>";*/
                }   
                else{
                    foreach($errores as $error){
                        echo '<br>' . $error;
                }
            }
            }
        }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../diseño/estilosform.css">
    <link rel="icon" href="../imagenes/logo.png">
    <title>Actualizar usuario</title>
</head>
<body>
<header>
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
        <nav class="menu">
            <ul class="menu-principal">
            <li><a href="../Reserva/ver_reservas.php">Reserva</a>
            <ul class="submenu">
            </ul>
           <li><a href="../Habitaciones/habitaciones.php">Habitaciones</a></li>
            <?php if(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']!=2):?>
            <li><a href="vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="salir.php" onclick='return confirmacion()'>Salir</a></li>
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
    <?php if(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']!=2):?>
    <form class="formulario" method="POST" enctype="multipart/form-data">
    <div>
        <h1>Actualización persona</h1>
        <fieldset>
        <input class ="control" type="text" name="num_doc" id="Documento" disabled value="<?php echo $Documento;?>">
            <select class="control" name="tipo_doc" id="tipo_doc" disabled>
                <option <?php echo $TipoDocumento==='Cédula de ciudadanía'? "selected='selected'":""?> value="Cédula de ciudadanía">Cédula de ciudadanía</option>
                <option <?php echo $TipoDocumento==='Cédula de extranjería'? "selected='selected'":""?> value="Cédula de extranjería">Cédula de extranjería</option>
                <option <?php echo $TipoDocumento==='Pasaporte'? "selected='selected'":""?> value="Pasaporte">Pasaporte</option>
            </select>
            <input class ="control" type="text" name="nombres" id="Nombre" value="<?php echo $Nombre;?>">
            <input class ="control" type="text" name="apellidos" id="Apellido" value="<?php echo $Apellido;?>">
            <input class="control" type="text" name="email" id="email" value="<?php echo $Email;?>" disabled>
            <input class="control" type="password" name="contraseña" id="contraseña" placeholder="Contraseña nueva si lo requiere">
            <input class="control" type="text" name="telefono" id="telefono" value="<?php echo $Telefono;?>">
            <input class="control" type="text" name="direccion" id="direccion" value="<?php echo $Direccion;?>">
            <br>
            <?php if($FotoB!=null):?>
                <span class="datos"><img class="avatar" src="<?php echo $FotoB;?>" alt=""></span>
            <br>
            <?php else:?>
                <span class="datos">
                    <img class="avatar" src="<?php echo $FotoB;?>" alt=""></span>
            <br>
            <?php endif; ?>
            <br>
            <input class="archivo" type="file" name="foto" id="">
            <br>    
            <input class ="boton" type="submit" id="Enviar" name="Enviar" value="Actualizar">
        </fieldset>
    </form>
    <?php else:?>
        <form class="formulario" method="POST" enctype="multipart/form-data">
    <div>
        <h1>Actualización persona</h1>
        <fieldset>
        <input class ="control" type="text" name="num_doc" id="Documento" value="<?php echo $Documento;?>">
            <select class="control" name="tipo_doc" id="tipo_doc">
                <option <?php echo $TipoDocumento==='Cédula de ciudadanía'? "selected='selected'":""?> value="Cédula de ciudadanía">Cédula de ciudadanía</option>
                <option <?php echo $TipoDocumento==='Cédula de extranjería'? "selected='selected'":""?> value="Cédula de extranjería">Cédula de extranjería</option>
                <option <?php echo $TipoDocumento==='Pasaporte'? "selected='selected'":""?> value="Pasaporte">Pasaporte</option>
            </select>
            <input class ="control" type="text" name="nombres" id="Nombre" value="<?php echo $Nombre;?>">
            <input class ="control" type="text" name="apellidos" id="Apellido" value="<?php echo $Apellido;?>">
            <input class="control" type="text" name="email" id="email" value="<?php echo $Email;?>">
            <input class="control" type="password" name="contraseña" id="contraseña" placeholder="Contraseña nueva si lo requiere">
            <input class="control" type="text" name="telefono" id="telefono" value="<?php echo $Telefono;?>">
            <input class="control" type="text" name="direccion" id="direccion" value="<?php echo $Direccion;?>">
            <select class="control" name="cod_usuario" id="nombre_tipo">
                <option <?php echo $TipoPersona==='1'? "selected='selected'":""?> value="1">Cliente</option>
                <option <?php echo $TipoPersona==='2'? "selected='selected'":""?> value="2">Empleado</option>
            </select>
            <br>
            <?php if($FotoB!=null):?>
                <span class="datos" name="foto"><img class="avatar" src="<?php echo $FotoB;?>" alt=""></span>
            <br>
            <?php else:?>
                <span class="datos">
                    <img class="avatar" src="<?php echo $FotoB;?>" alt=""></span>
            <br>
            <?php endif; ?>
            <br>
            <input class="archivo" type="file" name="foto" id="">
            <br>    
            <input class ="boton" type="submit" id="Enviar" name="Enviar" value="Actualizar">
        </fieldset>
    </form>
    <?php endif;?>
</div>
<script>
    window.onbeforeunload = function() {
        return "¿Estás seguro de que quieres abandonar la página sin actualizar los datos?";
    };

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('form').addEventListener('submit', function(e) {
            window.onbeforeunload = null;
        });
    });
</script>
</body>
</html>