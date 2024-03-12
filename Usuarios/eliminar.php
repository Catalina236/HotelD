<?php 
require '../Bd/conexion.php';

//Verificar con filter validate que el dato enviado sea válido para poder eliminar por el codigo del cliente que se recibe en el GET
$codigo_eliminar = $_GET['correo_electronico'];
$codigo_eliminar = filter_var($codigo_eliminar, FILTER_SANITIZE_EMAIL);

if(!$codigo_eliminar){
    header('../index.php');
}

$bd = conectar_db();
$sql = "DELETE FROM usuarios WHERE correo_electronico = '$codigo_eliminar'";
echo $sql;
$resultado = mysqli_query($bd, $sql);

if($resultado){
    echo "<script type='text/javascript'>
    alert ('Usuario eliminado correctamente...');
    window.location='../index.php';
    </script>";
}