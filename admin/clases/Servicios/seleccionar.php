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
    <link rel="stylesheet" href="../../Diseño/estile.css">
    <link rel="icon" href="../../imagenes/logo.png">
    <title>Servicios</title>
    
</head>
<body>
    <div class="contenedor-tabla">
        <table>
            <thead bgcolor=#8CAAF8>
                <tr>
                    <th colspan="11">
                        <h2>Servicios</h2>
                    </th>
                    <th><a href="registrar_serv.php"><img src="../../imagenes/restaurante.png" alt=""></a></th> 
                </tr>

                <tr>
                    <th>Código servicio</th>
                    <th>Id bar</th>
                    <th>Producto bar</th>
                    <th>Valor bar</th>
                    <th>Id zonas humedas</th>
                    <th>Zonas húmedas</th>
                    <th>Valor zonas húmedas</th>
                    <th>Id restaurante</th>
                    <th>Producto restaurante</th>
                    <th>Valor restaurante</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datos as $row) { ?>
                    <tr>
                        <td><?php echo $row['cod_servicio'];?></td>
                        <td><?php echo $row['id_bar'];?></td>
                        <td><?php echo $row['nom_producto_bar'];?></td>
                        <td><?php echo $row['valor_bar'];?></td>
                        <td><?php echo $row['id_zon_hum'];?></td>
                        <td><?php echo $row['nom_servicio_zh'];?></td>
                        <td><?php echo $row['valor_zh'];?></td>
                        
                        <td><?php echo $row['id_rest'];?></td>
                        <td><?php echo $row['nom_producto_rest'];?></td>
                        <td><?php echo $row['valorR'];?></td>
                        <td><a href="editar_serv.php?cod=<?php echo $row['cod_servicio'];?>"><img src="../../imagenes/editar.png" alt=""></a></td>
                        <td>
                        <a class="eliminar" id="eliminar" onclick='return confirmacion()' href="eliminar.php?cod=<?php echo $row['cod_servicio'];?>"><img src="../../imagenes/eliminar.png" alt=""></a></td>
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
<script>
        function confirmacion(){
            var respuesta=confirm('¿Desea borrar el registro?');
            if(respuesta==true){
                return true;
            }
            else{
                return false;
            }
        }
    </script>
</body>
</html>