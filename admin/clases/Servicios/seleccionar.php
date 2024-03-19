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
$trabajo=new Trabajo();
$pagina_actual=isset($_GET['pagina'])? $_GET['pagina']:1;
$resultado_pagina=10;
$inicio=($pagina_actual-1)* $resultado_pagina;
$datos=$trabajo->DatoServicios($inicio,$resultado_pagina);
$total=$trabajo->VerServicios();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios</title>
    <link rel="stylesheet" href="../../Diseño/estile.css">
</head>
<body>
    <div class="contenedor-tabla">
        <table>
            <thead bgcolor=#8CAAF8>
                <tr>
                    <th colspan="5">
                        <h2>Servicios</h2>
                    </th>
                    <th><a href="registrar_serv.php"><img src="../../imagenes/restaurante.png" alt=""></a></th> 
                </tr>

                <tr>
                    <th>ID restaurante</th>
                    <th>Codigo Servicio</th>
                    <th>Nombre del producto</th>
                    <th>Valor</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datos as $row) { ?>
                    <tr>
                        <td><?php echo $row['id_rest'];?></td>
                        <td><?php echo $row['cod_servicio'];?></td>
                        <td><?php echo $row['nom_producto_rest'];?></td>
                        <td><?php echo $row['valor'];?></td>
                        <td><img src="../../imagenes/editar.png" alt=""></td>
                        <td><img src="../../imagenes/delete.png" alt=""></td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>

    <div style="text-align: center;">
    <a href="../../../Usuarios/opciones.php" class="linkregreso">Regresar</a>
    <?php 
    
    $total_paginas=ceil($total/$resultado_pagina);

    if ($pagina_actual > 1) {
        $pagina_anterior=$pagina_actual-1;
        echo "<a href='index.php?pagina=$pagina_anterior' class='enlace'>Anterior</a>";
    }  

    if ($pagina_actual < $total_paginas) {
        $siguiente_pagina = $pagina_actual + 1;
        echo "<a class='enlaces' href='index.php?pagina=$siguiente_pagina'>          Siguiente</a> <br>";
    }
    
    if($total_paginas>2){
        for ($i = 1; $i <= $total_paginas; $i++) {
            echo"<a class='enlace' href='index.php?pagina=".$i."'> ".$i." </a> ";
        }
    }
    ?>
</div>
</body>
</html>