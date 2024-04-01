<?php
require_once("../class.php");
$valo=new Trabajo();

if(isset($_POST['Enviar'])){
    $cod_servicio=$_POST['cod_servicio'];
    $s1=$_POST['id_rest'];
    $s2=$_POST['nom_producto_rest'];
    $s3=$_POST['valor'];
    
    $valor=$valo->actualizar_servicio($cod_servicio, $s1,$s2,$s3);
}
if(isset($_GET['cod'])){
    $serv1=$_GET['cod'];
    //$tipos=$valo->VerServicios();
    //$servcio=$valo->traer_servicios($serv1);
    $datos=$valo->traer_servicios($serv1);
    $cod_servicio=$datos[0]["cod_servicio"];
    $s1_rest = $datos[0]['id_rest'];
    $s1_bar = $datos[0]['id_bar'];
    $s1_zon_hum = $datos[0]['id_zon_hum'];
    if (!empty($s1_rest)) {
        $s1=$s1_rest;
        $s2=$datos[0]["nom_producto_rest"];
        $s3=$datos[0]["valorR"];
    } elseif (!empty($s1_bar)) {
        $s1=$s1_bar;
        $s2=$datos[0]["nom_producto_bar"];
        $s3=$datos[0]["valor_bar"];
    } elseif (!empty($s1_zon_hum)) {
        $s1=$s1_zon_hum;
        $s2=$datos[0]["nom_servicio_zh"];
        $s3=$datos[0]["valor_zh"];
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
    
    <title>Actualizar datos</title>
</head>
<body>
<form action="" method="POST">
        <h1>Actualizar servicio</h1>
        <label for="">Codigo Servicio</label>
        <input type="text" name="cod_servicio" class="casilla" value="<?php echo $cod_servicio; ?>"><br>
        <label for="">Id Servicio</label>
        <input type="text" name="id_rest" class="casilla" value="<?php echo $s1; ?>">
        <label for="">Nombre Producto</label>
        <input type="text" name="nom_producto_rest" class="casilla" value="<?php echo $s2;?>">
        <label for="">Valor</label>
        <input type="text" name="valor" class="casilla" value="<?php echo $s3;?>">
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