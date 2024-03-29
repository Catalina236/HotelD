<?php
require '../Bd/conexion.php';
$db = conectar_db();    
session_start();
if(!isset($_SESSION['cod_usuario'])){
    header("Location:../index.php");
}
else{
    if($_SESSION['cod_usuario']!=2){
        header("Location:../index.php");
    }
}
$sql = "SELECT * FROM persona JOIN usuarios ON persona.correo_electronico=usuarios.correo_electronico JOIN tipo_persona ON tipo_persona.cod_usuario=persona.cod_usuario;";
$consulta = mysqli_query($db, $sql);
?>
    <head>
        <title>Usuarios</title>
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="../diseño/estilosver.css">
        <link rel="icon" href="../imagenes/logo.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css"><script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>

    </head>
    <h4>Consulta de personas</h4>
    <a href="opciones.php"><input type="button" id="regresar" name="regresar" value="Regresar"></a>
    <a href="crear.php"><input type="button" value="Crear usuario"></a>
    <table>
        <tr>
            <thead>
                <th>Numero de documento</th>
                <th>Tipo de documento</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Tipo de usuario</th>
                <th>Avatar</th>
            </thead>
            <tbody>
                </tr>
                
                <?php while($persona = mysqli_fetch_assoc($consulta)) 
                {
                    if ($persona['foto'] != null) {
                        $foto = "imagenesbd/" . $persona['foto'];
                    } else {
                        // Si la foto está nula o no se encuentra, usar una imagen predeterminada
                        $foto = "imagenesbd/usuario.png";
                    }
                    ?>
                <tr>
                    <td><?php echo $persona['num_doc'];?></td>
                    <td><?php echo $persona['tipo_doc'];?></td>
                    <td><?php echo $persona['nombres'];?></td>
                    <td><?php echo $persona['apellidos'];?></td>
                    <td><?php echo $persona['correo_electronico'];?></td>
                    <td><?php echo $persona['telefono'];?></td>
                    <td><?php echo $persona['direccion'];?></td>
                    <td><?php echo $persona['nom_tipo_usuario'];?></td>
                    <td><img class="avatar" src="<?php echo $foto;?>" alt=""></td>
                    <td><a href="actualizar.php?correo_electronico=<?php echo $persona['correo_electronico'];?>&num_doc=<?php echo $persona['num_doc'];?>">Actualizar</a></td>
                    <td><a href="eliminar.php?correo_electronico=<?php echo $persona['correo_electronico'];?>" onclick="return confirmacion()">Eliminar</a></td>

                </tr>
                
            </tbody>
            <?php };?>
    </table>
    <script>
        function confirmacion(){
            var respuesta=confirm("¿Desea borrar el registro?");
            if(respuesta==true){
                return true;
            }
            else{
                return false;
            }
        }
    </script>
    <?php 
mysqli_close($db);