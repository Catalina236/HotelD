
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <?php require('inc/links.php'); ?>
    <title>Confirmar reserva</title>
</head>
<body class="bg-light">
    <?php
    session_start();
    require '../Bd/conexion.php';
    $bd=conectar_db();
    $codigo = $_GET['cod_tipo_hab'];
    
    $sql2="SELECT * FROM tipo_habitacion JOIN habitacion ON tipo_habitacion.cod_tipo_hab=habitacion.cod_tipo_hab WHERE tipo_habitacion.cod_tipo_hab='$codigo'";
    $resultado2=mysqli_query($bd,$sql2);
    $habitacion=mysqli_fetch_assoc($resultado2);

    
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">RESERVA CONFIRMADA</h2>
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
                                    <label class="form-label">Check-in</label>
                                    <input name="checkin" onchange="check_availability()" type="date" class="form-control shadow-none" require>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Check-out</label>
                                    <input name="checkout" type="date" class="form-control shadow-none" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Método de pago</label>
                                    <select name="metodo_pago" id="" class="form-control shadow-none" required>
                                        <option value="">Seleccione método de pago</option>
                                        <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                                        <option value="Tarjeta de débito">Tarjeta de débito</option>
                                        <option value="Efectivo">Efectivo</option>
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
                        $Precio=$habitacion['valor_base'];
                        $codigo=$habitacion['cod_tipo_hab'];
                        $MetodoPago=$_POST['metodo_pago'];
                        $sqlr = "SELECT * FROM reserva WHERE (fecha_inicio <= '$Fechaf' AND fecha_fin >= '$Fechai') AND cod_tipo_hab='$codigo'";

                        $resultado = mysqli_query($bd, $sqlr);
                        $datosr = mysqli_fetch_assoc($resultado);

                        if($datosr) {
                            echo "Error: Ya hay una reserva existente para estas fechas. Seleccione una habitación o fecha diferente.";
                        }
                        else{
                            if(!isset($_SESSION['cod_usuario'])){
                            echo "<script type='text/javascript'>alert('Para hacer una reserva, debe iniciar sesión');
                                window.location='../Usuarios/iniciarsesion.php';
                                </script>";
                            }    
                            else{
                                $id=$_SESSION['correo_electronico'];
                                $sql="SELECT * FROM persona WHERE correo_electronico='$id'";
                                $resultado=mysqli_query($bd,$sql);
                                $datos=mysqli_fetch_assoc($resultado);
                                $num_doc=$datos['num_doc'];
                                

                                $sql_insert = "INSERT INTO reserva (fecha_inicio, fecha_fin, precio, cod_tipo_hab, num_doc) VALUES ('$Fechai', '$Fechaf', '$Precio', '$codigo','$num_doc')";
                                $resultado=mysqli_query($bd, $sql_insert);
                                
                                //$sqlc="SELECT * FROM reserva";
                                //$sqlc="SELECT * FROM reserva JOIN persona ON reserva.num_doc=persona.num_doc";
                                $cod_reserva1 = mysqli_insert_id($bd);
                                $sqlc="SELECT * FROM reserva JOIN persona ON reserva.num_doc=persona.num_doc JOIN carrito_persona ON persona.num_doc=carrito_persona.num_doc";
                                $resultado=mysqli_query($bd,$sqlc);
                                $datosr=mysqli_fetch_assoc($resultado);
                                //$cod_reserva=$datosr['cod_reserva'];
                                $cod_carrito=$datosr['cod_carrito'];
                                
                                if($cod_carrito==""){
                                    $fecha_factura=date("Y/m/d");
                                    $sqlf="INSERT INTO factura(fecha_factura,metodo_pago,num_doc,cod_reserva) VALUES('$fecha_factura','$MetodoPago','$num_doc','$cod_reserva1')";
                                    $resultado=mysqli_query($bd,$sqlf);
                                    if ($resultado) {
                                        $cod_factura = mysqli_insert_id($bd);
                                        var_dump($cod_factura);
                                        $sql_df="INSERT INTO detalle_factura(cod_factura) VALUES ('$cod_factura')";
                                        
                                        $resultado=mysqli_query($bd,$sql_df);
                                        if($resultado){
                                            echo "<script type='text/javascript'>alert('Reserva generada exitosamente');
                                            window.location='ver_reservas.php';
                                            </script>";
                                        } else {
                                            echo "Error al realizar la reserva: " . mysqli_error($bd);
                                        }
                                        
                                        } else {
                                            echo "Error al insertar la factura: " . mysqli_error($bd);
                                        }
                                }
                                else{
                                    $fecha_factura=date("Y/m/d");
                                    $sqlf="INSERT INTO factura(fecha_factura,metodo_pago,num_doc,cod_reserva,cod_carrito) VALUES('$fecha_factura','$MetodoPago','$num_doc','$cod_reserva1','$cod_carrito')";
                                    $resultado=mysqli_query($bd,$sqlf);
                                    if ($resultado) {
                                        $cod_factura = mysqli_insert_id($bd);
                                        $sql_cantidad="SELECT COUNT(*) FROM persona JOIN carrito_persona ON persona.num_doc=carrito_persona.num_doc WHERE persona.num_doc='$num_doc'";
                                        $rconsulta=mysqli_query($bd,$sql_cantidad);
                                        $cantidad=mysqli_fetch_assoc($rconsulta);
                                        $cantidad=$cantidad["COUNT(*)"];
                                        
                                        $sql_df="INSERT INTO detalle_factura(cod_factura,cod_carrito,cantidad_serv_adquiridos) VALUES ('$cod_factura','$cod_carrito','$cantidad')";
                                        
                                        $resultado=mysqli_query($bd,$sql_df);
                                        if($resultado){
                                            echo "<script type='text/javascript'>alert('Reserva generada exitosamente. Los servicios del carrito fueron añadidos. Puede consultar el valor total en ver factura');
                                            window.location='ver_reservas.php';
                                            </script>";
                                        } else {
                                            echo "Error al realizar la reserva: " . mysqli_error($bd);
                                        }
                                        
                                        } else {
                                            echo "Error al insertar la factura: " . mysqli_error($bd);
                                        }      
                                }
                            }
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