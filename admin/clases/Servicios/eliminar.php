<?php
require_once('../class.php');
session_start();
if(!isset($_SESSION['cod_usuario'])){
    header("Location:../index.php");
}
else{
    if($_SESSION['cod_usuario']!=2){
        header("Location:../index.php");
    }
}
$dato=new Trabajo();
if(isset($_GET['cod'])){
    $cod=$_GET['cod'];
    $codigo=$dato->eliminar_servicio($cod);

    //echo 'La reserva se canceló exitosamente...';
}
?>