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

if(isset($_GET['cod'])){
    $v1=$_GET['cod'];
    $tipos=$valo->traerTipoHabitacion();
    $estado=$valo->TraerEstado($v1);
    $datos=$valo->traerHabitacion($v1);
    $id=$datos[0]["cod_tipo_hab"];
    $d2=$datos[0]["nom_tipo_hab"];
    $d3=$datos[0]["capacidad"];
    $d4=$datos[0]["valor_base"];
    $d5=$datos[0]["nro_hab"];
    $d6=$datos[0]["estado_hab"];
    $d7=$datos[0]["descripcion_hab"];
    $ImgActual=$datos[0]['imagen'];
}
if(isset($_POST['Enviar'])){
    $id=$_POST['codigo'];
    $d2=$_POST['tipo'];
    $d3=$_POST['capacidad'];
    $d4=$_POST['precio'];
    $d5=$_POST['numero'];
    $d6=$_POST['estado'];
    $d7=$_POST['descripcion'];
    $d8=$_FILES['imagen']['name'];
    $temp = "";
    //$d8=$_POST['imagen'];
    if(!empty($d8)){
        $tipo=$_FILES['imagen']['type'];
        $temp=$_FILES['imagen']['tmp_name'];
    }
    else{
        $d8=$ImgActual;
    }
    $valor=$valo->actualizar_habitacion($id,$d2,$d3,$d4,$d5,$d6,$d7,$d8,$temp);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Diseño/estilos.css">
    <link rel="icon" href="../../imagenes/logo.png">
    <title>Actualizar habitación</title>
</head>
<body>
    <form method="POST" class="form_hab" enctype="multipart/form-data">
    <div class="contenedor">
        <h1>Registro de habitación</h1>
        <label for="">Código tipo de habitación</label>
        <input class="casilla" type="number" name="codigo" id="" value="<?php echo $id;?>">
        <label for="">Número de habitación</label>
        <input class="casilla" type="number" name="numero" id="" value="<?php echo $d5;?>">
        <label for="">Tipo de habitación</label>
        <select class="casilla" name="tipo" id="">
        <?php
        for($i = 0; $i < sizeof($tipos); $i++) {
            $t2 = $tipos[$i]["nom_tipo_hab"];
            if ($t2 == $d2) {
                echo '<option value="'.$t2.'" selected>'.$t2.'</option>';
            } else {
                echo '<option value="'.$t2.'">'.$t2.'</option>';
            }
        }
        ?>
</select>
        <label for="">Capacidad</label>
        <input class="casilla" type="number" name="capacidad" id="" value="<?php echo $d3;?>">
        <label for="">Precio</label>
        <input class="casilla" type="text" name="precio" id="" value="<?php echo $d4;?>">
        <label for="">Estado</label>
        <select class="casilla" name="estado" id="">
            <option <?php echo $d6==='Disponible'? "selected='selected'":""?> value="Disponible">Disponible</option>
            <option <?php echo $d6==='Ocupada'? "selected='selected'":""?> value="Ocupada">Ocupada</option>
            <option <?php echo $d6==='Mantenimiento'? "selected='selected'":""?>value="Mantenimiento">Mantenimiento</option>
        </select>
        <label for="">Descripción</label>
        <input class="casilla" name="descripcion" type="text" value="<?php echo $d7;?>">
        <label for="">Imagen</label>
        <input type="file" name="imagen" class="casilla">
        <span class="imagen_hab"><img src="imagenes/<?php echo $ImgActual;?>" alt=""></span>
        <input class="casilla" type="submit" value="Enviar" name="Enviar">
        </div>
    </form>
</body>
</html>