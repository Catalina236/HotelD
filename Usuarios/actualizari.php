<?php
require '../Bd/conexion.php';
$bd=conectar_db();
session_start();
if (!isset($_SESSION['cod_usuario'])){
    header("Location:../index.php");
}
$id=$_GET['correo_electronico'];
$id=filter_var($id, FILTER_SANITIZE_EMAIL);
$sql="SELECT * FROM usuarios JOIN persona ON usuarios.correo_electronico=persona.correo_electronico WHERE persona.correo_electronico='$id'";
$consult=mysqli_query($bd, $sql);
$usuario=mysqli_fetch_assoc($consult);

$Documento=$usuario['num_doc'];
$TipoDocumento=$usuario['tipo_doc'];
$Nombre=$usuario['nombres'];
$Apellido=$usuario['apellidos'];
$Email=$usuario['correo_electronico'];
$Contraseña=$usuario['contraseña'];
$Telefono=$usuario['telefono'];
$Direccion=$usuario['direccion'];
$Foto=$usuario['foto'];

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
    $Foto=$_FILES['foto'];

    if(empty($errores)){
         
        $sql="UPDATE usuarios SET 
        correo_electronico='$Email',
        contraseña='$Contraseña',
        foto='$Foto'
        WHERE correo_electronico='$id';";
    
        $sql2 = "UPDATE persona SET 
        num_doc = '$Documento',
        tipo_doc = '$TipoDocumento',
        nombres = '$Nombre',
        apellidos = '$Apellido',
        correo_electronico = '$Email',
        telefono='$Telefono',
        direccion='$Direccion'
        WHERE correo_electronico= '$id'";

        if(isset($Foto) && $Foto !=""){
            $tipo=$_FILES['foto']['type'];
            $temp=$_FILES['foto']['tmp_name'];

        $resultado = mysqli_query($bd, $sql);
        $resultado2 = mysqli_query($bd, $sql2);

        if($resultado){
            move_uploaded_file($temp, 'imagenesbd/'.$Foto);
            header('location: ../index.php');

        }
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
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="../diseño/estilosform.css">
    <title>Actualizar usuario</title>
</head>
<body>
<header>
<a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
            <nav class="menu">
            <ul class="menu-principal">
                <li><a href="#">Reserva</a>
                <ul class="submenu">
                    <li><a href="">Crear reserva</a></li>
                    <li><a href="">Cancelar reserva</a></li>
                    <li><a href="">Consultar</a></li>
                </ul>
                </li>
                <li><a href="">Habitaciones</a>
                    <ul class="submenu">
                        <li><a href="">Doble</a></li>
                        <li><a href="">Sencilla</a></li>
                        <li><a href="">Triple</a></li>
                        <li><a href="">Familiar</a></li>
                    </ul>
                </li>
                <li><a href="Usuarios/iniciarsesion.php">Mi perfil</a>
                <ul class="submenu">
                    <li><a href="Usuarios/iniciarsesion.php">Actualizar perfil</a></li>
                </ul>
            </li>
                <li><a href="">Contáctenos</a></li>
                <li><a href="../Servicios/Servicios.php">Servicios</a>
                    <ul class="submenu">
                        <li><a href="#">Piscina</a></li>
                        <li><a href="Servicios.html">Restaurante</a></li>
                        <li><a href="">Gimnasio</a></li>
                        <li><a href="">Bar</a></li>
                        <li><a href="">Zonas húmedas</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="contenido">
        <div class="container">
        <form class="formulario" method="POST" enctype="multipart/form-data" action="actualizar.php">
    <h1>Actualización persona</h1>
        <fieldset>
        <input class ="control" type="text" name="num_doc" id="Documento" value="<?php echo $Documento;?>">
            <select class="control" name="tipo_doc" id="tipo_doc" required>
                <option value="">Tipo de documento</option>
                <option value="Cédula de ciudadanía">Cédula de ciudadanía</option>
                <option value="Cédula de extranjería">Cédula de extranjería</option>
                <option value="Pasaporte">Pasaporte</option>
            </select>
            <input class ="control" type="text" name="nombres" id="Nombre" value="<?php echo $Nombre;?>">
            <input class ="control" type="text" name="apellidos" id="Apellido" value="<?php echo $Apellido;?>">
            <input class="control" type="text" name="email" id="email" value="<?php echo $Email;?>">
            <input class="control" type="password" name="contraseña" id="contraseña" value="<?php echo $Contraseña;?>">
            <input class="control" type="text" name="telefono" id="telefono" value="<?php echo $Telefono;?>">
            <input class="control" type="text" name="direccion" id="direccion" value="<?php echo $Direccion;?>">
            <input type="file" name="foto" id="">
            <div class="containerimg">
            <img class=".imgac" src="imagenesbd/<?php echo $Foto;?>" alt="">
            </div>
            <input class ="boton" type="submit" id="Enviar" name="Enviar" value="Actualizar">
        </fieldset>
    </form>
        </div>
    </div>
</body>
</html>