<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <?php require('inc/links.php'); ?>
    <title>Modificar reserva</title>
</head>
<body class="bg-light">
<?php

require '../Bd/conexion.php';
$bd=conectar_db();
session_start();
if(!isset($_SESSION['cod_usuario'])){
    $Nombres="";
    $Telefono="";
    $Direccion="";
}    
else{
$id=$_SESSION['correo_electronico'];
$sql="SELECT * FROM persona WHERE correo_electronico='$id'";
$resultado=mysqli_query($bd,$sql);
$datos=mysqli_fetch_assoc($resultado);
}
$codigo = $_GET['cod_reserva'];

$sql2="SELECT * FROM reserva JOIN factura ON reserva.cod_reserva=factura.cod_reserva JOIN tipo_habitacion ON reserva.cod_tipo_hab=tipo_habitacion.cod_tipo_hab JOIN habitacion ON tipo_habitacion.cod_tipo_hab=habitacion.cod_tipo_hab WHERE reserva.cod_reserva='$codigo'";
$resultado2=mysqli_query($bd,$sql2);
$habitacion=mysqli_fetch_assoc($resultado2);
$Fechainicio=$habitacion['fecha_inicio'];
$Fechafin=$habitacion['fecha_fin'];
$TipoHab=$habitacion['nom_tipo_hab'];
$Precio=$habitacion['valor_base'];

?>
<div class="container">
    <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold">MODIFICAR RESERVA</h2>
            <div style="font-size: 14px;">
                <a href="../index.php" class="text-secondary text-decoration-none">INICIO</a>
                <span class="text-secondary"></span>
                <a href="../Reserva/reserva.php" class="text-secondary text-decoration-none">HABITACIONES</a>
                <span class="text-secondary"></span>
                <a href="#" class="text-secondary text-decoration-none">CONFIRMAR</a>
            </div>
        </div>

        <div class="col-lg-7 col-md-12 px-4">
                <div class="card p-3 shadow-sm rounded">
                <img src="../admin/clases/Habitacion/imagenes/<?php echo $habitacion['imagen'];?>" alt="">
                <br>
                <h4>Habitación <?php echo $TipoHab;?></h4>
                <h5>COP <?php echo $Precio;?> por noche</h5>
                </div>
            </div>
        
        <div class="col-lg-5 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <form action="" id="booking_form" method="post">
                        <h5 class="mb-3">Detalles de la reserva</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Check-in</label>
                                <input name="checkin" onchange="check_availability()" type="date" class="form-control shadow-none" require value="<?php echo $Fechainicio;?>">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Check-out</label>
                                <input name="checkout" type="date" class="form-control shadow-none" required value="<?php echo $Fechafin;?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Método de pago</label>
                                <select class="form-control shadow-none" name="metodo_pago" id="tipo_doc">
                                    <option <?php echo $habitacion['metodo_pago']==='Tarjeta de crédito'? "selected='selected'":""?> value="Tarjeta de crédito">Tarjeta de crédito</option>
                                    <option <?php echo $habitacion['metodo_pago']==='Tarjeta de débito'? "selected='selected'":""?> value="Tarjeta de débito">Tarjeta de débito</option>
                                    <option <?php echo $habitacion['metodo_pago']==='Efectivo'? "selected='selected'":""?> value="Efectivo">Efectivo</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>

                                <h6 class="mb-3 text-danger" id="pay-info">Proporcionar fecha de entrada y salida !</h6>
                                <input type="submit" value="Reservar" name="Reservar">
                            </div>
                        </div>
                    </form>
                <?php
                if(isset($_POST['Reservar'])){
                    $Fechai=$_POST['checkin'];
                    $Fechaf=$_POST['checkout'];
                    $Precio=$habitacion['precio'];
                    $codigo_hab=$habitacion['cod_tipo_hab'];
                    $num_doc=$datos['num_doc'];
                    $MetodoPago=$_POST['metodo_pago'];

                    $sql_u = "UPDATE reserva SET 
                    fecha_inicio = '$Fechai',
                    fecha_fin= '$Fechaf',
                    Precio='$Precio',
                    cod_tipo_hab='$codigo_hab',
                    num_doc='$num_doc'
                    WHERE cod_reserva = '$codigo'";

                    $sql_u1 = "UPDATE factura SET 
                    metodo_pago='$MetodoPago',
                    num_doc='$num_doc',
                    cod_reserva='$codigo'
                    WHERE cod_reserva = '$codigo'";

                    $resultado=mysqli_query($bd,$sql_u);
                    $resultado=mysqli_query($bd,$sql_u1);

                    if($resultado){
                        echo "<script type='text/javascript'>alert('Reserva actualizada exitosamente');
                        window.location='ver_reservas.php';
                        </script>";
                    } else {
                        echo "Error al actualizar la reserva: " . mysqli_error($bd);
                    }}
    ?>
    </div>
            </div>
        </div>

    </div>
</div>    
</body>
</html>