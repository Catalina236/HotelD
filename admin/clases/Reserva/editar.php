<?php
require_once("../class.php");
session_start();
if(!isset($_SESSION['cod_usuario'])){
    header("Location:../../../index.php");
}
else{
    if($_SESSION['cod_usuario']!=2){
        header("Location:../../../index.php");
    }
}

$valo=new Trabajo();

if(isset($_POST['Enviar'])){
    $cod=$_POST['codigo'];
    $d1=$_POST['fecha_inicio'];
    $d2=$_POST['fecha_fin'];
    $d3=$_POST['precio'];
    $d4=$_POST['cod_tipo'];
    $d5=$_POST['num_doc'];
    $valor=$valo->actualizar_reserva($cod, $d1,$d2,$d3,$d4,$d5);
}
if(isset($_GET['cod'])){
    $v1=$_GET['cod'];
    //$tipos=$valo->traerTipos();
    //$tipo_doc=$valo->traerTipodoc($v1);
    $datos=$valo->traer_Reserva($v1);

    $d1=$datos[0]["fecha_inicio"];
    $d2=$datos[0]["fecha_fin"];
    $d3=$datos[0]["precio"];
    $d4=$datos[0]["cod_tipo_hab"];
    $d5=$datos[0]["num_doc"];
    $cod=$datos[0]["cod_reserva"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Diseño/estilos.css">
    <link rel="icon" href="../../imagenes/logo.png">
    
    <title>Registrar reserva</title>
</head>
<body>
<form action="" method="POST">
<h1>Registro reserva</h1>
        <label for="">Fecha inicio</label>
            <input type="date" name="fecha_inicio" id="" class="casilla" value="<?php echo $d1;?>">
        <label for="">Fecha fin</label>
            <input type="date" name="fecha_fin" id="" class="casilla" value="<?php echo $d2;?>">
        <label for="">Precio</label>
            <input type="text" name="precio" id="" class="casilla" value="<?php echo $d3;?>">
        <label for="">Código tipo</label>
            <input type="text" name="cod_tipo" id="" class="casilla" value="<?php echo $d4;?>">
        <label for="">Número de documento</label>
            <input type="text" name="num_doc" id="" class="casilla" value="<?php echo $d5;?>">
        <input type="text" name="codigo" id="" value="<?php echo $cod;?>" hidden>
        <input type="submit" value="Enviar" name="Enviar" class="casilla">
    </form>
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