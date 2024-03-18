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

    if(empty($errores)){

        if ($_SESSION['cod_usuario']==2){
        $sql="UPDATE usuarios SET 
        correo_electronico='$Email',
        contraseña='$Contraseña'
        WHERE correo_electronico='$codigo2';";
    
        $sql2 = "UPDATE persona SET 
        num_doc = '$Documento',
        tipo_doc = '$TipoDocumento',
        nombres = '$Nombre',
        apellidos = '$Apellido',
        correo_electronico = '$Email',
        telefono='$Telefono',
        direccion='$Direccion'
        WHERE correo_electronico = '$codigo2'";
        
        echo $sql;
        echo $sql2;

        $resultado = mysqli_query($bd, $sql);
        $resultado = mysqli_query($bd, $sql2);

        if($resultado){
            header('location: verusuarios.php');

        }   
        }
        else{
            $sql="UPDATE usuarios SET
            contraseña='$Contraseña'
            WHERE correo_electronico='$codigo2';";
        
            $sql2 = "UPDATE persona SET 
            nombres = '$Nombre',
            apellidos = '$Apellido',
            telefono='$Telefono',
            direccion='$Direccion'
            WHERE correo_electronico = '$codigo2'";
            
            echo $sql;
            echo $sql2;
    
            $resultado = mysqli_query($bd, $sql);
            $resultado = mysqli_query($bd, $sql2);
    
            if($resultado){
                header('location: vercuenta.php');
    
            }   
        }
        }
        else{
            foreach($errores as $error){
                echo '<br>' . $error;
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
                <li><a href="../Reserva/reserva.php">Reserva</a>
                <ul class="submenu">
                    <li><a href="">Crear reserva</a></li>
                    <li><a href="">Cancelar reserva</a></li>
                    <li><a href="">Consultar</a></li>
                </ul>
                </li>
                <li><a href="../Habitaciones/habitaciones.php">Habitaciones</a></li>
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
    <?php if(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']!=2):?>
    <form class="formulario" method="POST">
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
            <input class="control" type="password" name="contraseña" id="contraseña" value="<?php echo $Contraseña;?>">
            <input class="control" type="text" name="telefono" id="telefono" value="<?php echo $Telefono;?>">
            <input class="control" type="text" name="direccion" id="direccion" value="<?php echo $Direccion;?>">
            <input class ="boton" type="submit" id="Enviar" name="Enviar" value="Actualizar">
        </fieldset>
    </form>
    <?php else:?>
        <form class="formulario" method="POST">
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
            <input class="control" type="password" name="contraseña" id="contraseña" value="<?php echo $Contraseña;?>">
            <input class="control" type="text" name="telefono" id="telefono" value="<?php echo $Telefono;?>">
            <input class="control" type="text" name="direccion" id="direccion" value="<?php echo $Direccion;?>">
            <select class="control" name="nombre_tipo" id="nombre_tipo">
                <option <?php echo $TipoPersona==='1'? "selected='selected'":""?> value="Cliente">Cliente</option>
                <option <?php echo $TipoPersona==='2'? "selected='selected'":""?> value="Empleado">Empleado</option>
            </select>
            <input class ="boton" type="submit" id="Enviar" name="Enviar" value="Actualizar">
        </fieldset>
    </form>
    <?php endif;?>
</div>
</body>
</html>