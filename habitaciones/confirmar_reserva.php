<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../diseño/estilo.css">
    <?php require('inc/links.php'); ?>
    <!--<title><?php echo $settings_r['site_title'] ?> - CONFIRMAR RESERVA</title>-->
    <title> - CONFIRMAR RESERVA</title>
</head>
<body class="bg-light">
    

    <?php

    require '../Bd/conexion.php';
    $bd=conectar_db();
    session_start();
    if(!isset($_SESSION['cod_usuario'])){
        header("Location: ../index.php");
    }
    $id=$_SESSION['correo_electronico'];
    if(isset($_GET['cod_tipo_hab'])) {
        $codigo = $_GET['cod_tipo_hab'];
        
    $sql2="SELECT * FROM tipo_habitacion JOIN habitacion ON tipo_habitacion.cod_tipo_hab=habitacion.cod_tipo_hab WHERE tipo_habitacion.cod_tipo_hab='$codigo'";
    $resultado2=mysqli_query($bd,$sql2);
    $habitacion=mysqli_fetch_assoc($resultado2);

    } else {
        // Manejar el caso en el que 'cod_tipo_hab' no está definido
    }
    $sql="SELECT * FROM persona WHERE correo_electronico='$id'";
    $resultado=mysqli_query($bd,$sql);
    $datos=mysqli_fetch_assoc($resultado);
    
    ?>
    <div class="container">
        <div class="row">

            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">RESERVA CONFIRMADA</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">INICIO</a>
                    <span class="text-secondary"></span>
                    <a href="habitaciones.php" class="text-secondary text-decoration-none">HABITACIONES</a>
                    <span class="text-secondary"></span>
                    <a href="#" class="text-secondary text-decoration-none">CONFIRMAR</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                    <div class="card p-3 shadow-sm rounded">
                    <img src="../admin/clases/Habitacion/imagenes/<?php echo $habitacion['imagen'];?>" alt="">
                    <br>
                    <h4>Habitación <?php echo $habitacion['nom_tipo_hab'];?></h4>
                    <h5>COP <?php echo $habitacion['valor_base'];?> por noche</h5>
                    </div>
                </div>
            
            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form action="" id="booking_form" method="post">
                            <h5 class="mb-3">Detalles de la reserva</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre</label>
                                    
                                    <input name="nombre" type="text" class="form-control shadow-none" require value="<?php echo $datos['nombres'];?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Numero de telefono</label>
                                    
                                    <input name="telefono" type="text" class="form-control shadow-none" require value="<?php echo $datos['telefono'];?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Direccion</label>
                                    <textarea name="direccion" class="form-control shadow-none" rows="1" required><?php echo $datos['direccion'] ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-in</label>
                                    <input name="checkin" onchange="check_availability()" type="date" class="form-control shadow-none" require>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Check-out</label>
                                    <input name="checkout" type="date" class="form-control shadow-none" required>
                                </div>

                                <div class="col-12">
                                    <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                        <span class="visually-hidden">Cargando...</span>
                                    </div>

                                    <h6 class="mb-3 text-danger id="pay-info">Proporcionar fecha de entrada y salida !</h6>
                                    <input type="submit" value="Reservar" name="Reservar">
                                </div>
                            </div>
                        </form>
                        <?php
                                    if(isset($_POST['Reservar'])){
                                        $Fechai=$_POST['checkin'];
                                        $Fechaf=$_POST['checkout'];
                                        $Precio=$habitacion['valor_base'];
                                        $codigo=$habitacion['cod_tipo_hab'];
                                        $num_doc=$datos['num_doc'];

                                        $sql_insert = "INSERT INTO reserva (fecha_inicio, fecha_fin, precio, cod_tipo_hab, num_doc) 
                                        VALUES ('$Fechai', '$Fechaf', '$Precio', '$codigo','$num_doc')";
                 
                         // Ejecutar la consulta
                         if(mysqli_query($bd, $sql_insert)){
                             echo "La reserva se ha realizado correctamente.";
                         } else {
                             echo "Error al realizar la reserva: " . mysqli_error($bd);
                         }
                     }
                                    ?>
                    </div>
                </div>
            </div>

        </div>
    </div>    
</body>
</html>