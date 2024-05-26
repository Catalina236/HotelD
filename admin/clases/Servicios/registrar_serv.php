<?php
require_once('../class.php');
session_start();
if(!isset($_SESSION['cod_usuario'])){
    header("Location:../../../index.php");
}
else{
    if($_SESSION['cod_usuario']!=2){
        header("Location:../../../index.php");
    }
}
$dato = new Trabajo();
if(isset($_POST['Enviar'])){
    $cod_servicio=$_POST['cod_servicio'];
    $num_doc_cliente=$_POST['num_doc_cliente'];
    $id_rest=$_POST['id_rest'];
    $nom_producto=$_POST['nom_producto'];
    $valor_rest=$_POST['valor'];
    $descripcion=$_POST['descripcion'];
    $foto=$_FILES['foto']['name'];
    if(isset($foto) && $foto!=""){
        $tipo=$_FILES['foto']['type'];
        $temp=$_FILES['foto']['tmp_name'];
        $dato->insertarServicio($cod_servicio,$num_doc_cliente,$id_rest,$nom_producto,$valor_rest,$descripcion,$foto,$temp);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Diseño/estilos.css">
    <link rel="icon" href="../../imagenes/logo.png">
    <title>Servicio</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <h1>Registro Servicios</h1>
        <label for="">Codigo Servicio</label>
        <input type="text" name="cod_servicio" id="" class="casilla">
        <label for="">Numero de Documento</label>
        <input type="text" name="num_doc_cliente" id="" class="casilla"><br>
        <label for="">Id Servicio</label>
        <input ztype="text" name="id_rest" id="" class="casilla">
        <label for="">Nombre del Producto</label>
        <input type="text" name="nom_producto" class="casilla">
        <label for="">Valor</label>
        <input type="text" name="valor" class="casilla">
        <label for="">Descripción</label>
        <input type="text" name="descripcion" id="" class="casilla">
        <label for="">Foto Servicio</label>
        <input type="file" name="foto" id="">
        <input type="submit" name="Enviar" class="casilla">
    </form>
</body>
</html>