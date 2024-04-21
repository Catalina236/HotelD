
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="../diseño/estilosverusuario.css">
    <?php require('inc/links.php'); ?>
    <title>Confirmar reserva</title>
</head>
<header>
        <a href="../index.php"><img src="../imagenes/logo.png" alt="" class="logo"></a>
        <nav class="menu">
        <ul class="menu-principal">
            <li><a href="../Reserva/ver_reservas.php">Reserva</a>
            <ul class="submenu">
            </ul>
            </li>
                <li><a href="../Habitaciones/habitaciones.php">Habitaciones</a></li>
            <?php if(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']!=2):?>
            <li><a href="../Usuarios/vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="../Usuarios/salir.php" onclick='return confirmacion()'>Salir</a></li>
                </ul>
            </li>
            <?php elseif(isset($_SESSION['cod_usuario']) && $_SESSION['cod_usuario']==2):?>
            <li><a href="../Usuarios/vercuenta.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="../Usuarios/opciones.php">Opciones</a></li>
                    <li><a href="../Usuarios/salir.php" onclick='return confirmacion()'>Salir</a></li>
                </ul>
                </li>
            <?php else :?>
            <li><a href="../Usuarios/iniciarsesion.php">Mi Perfil</a>
                <ul class="submenu">
                    <li><a href="../Usuarios/iniciarsesion.php">Iniciar sesión</a></li>
                    <li><a href="../Usuarios/crear.php">Registrarse</a></li>
                </ul>
            </li>
            <?php endif;?>
                <li><a href="">Contáctenos</a></li>
            <li><a href="../Servicios/servicios.php">Servicios</a>
            <ul class="submenu">
                <li><a href="../Servicios/serviciores.php">Restaurante</a></li>
                <li><a href="../Servicios/serviciobar.php">Bar</a></li>
                <li><a href="../Servicios/serviciozona.php">Zonas húmedas</a></li>
                </ul>
            </li>
        </ul>
        </nav>
    </header>

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
                                $sqlu="SELECT * FROM persona WHERE correo_electronico='$id'";
                                $resultado=mysqli_query($bd,$sqlu);
                                if($resultado){
                                    $datosu=mysqli_fetch_assoc($resultado);
                                    $num_doc=$datosu['num_doc'];
                                    if($Fechai>$Fechaf || $Fechaf<$Fechai){
                                        echo 'No se puede hacer una reserva con una fecha de inicio mayor a la final...Seleccione una fecha diferente e intente nuevamente';
                                    }
    
                                    else{
                                        /*$finicio=strtotime($Fechai);
                                        $ffin=strtotime($Fechaf);
                                        $diferencia=$ffin-$finicio;
                                        $segundosporDia=60*60*24;
                                        $dias=$diferencia/$segundosporDia;
                                        $Total=$dias*$Precio;*/

                                        $sql_insert="INSERT INTO reserva(fecha_inicio,fecha_fin,precio,cod_tipo_hab,num_doc) VALUES('$Fechai','$Fechaf','$Precio','$codigo','$num_doc')";
                                        $reservar=mysqli_query($bd,$sql_insert);
                                        $cod_reserva=mysqli_insert_id($bd);
                                        $fecha_factura=date("Y/m/d");
                                        if($reservar){

                                            $result=mysqli_query($bd,"SELECT * FROM carrito_persona JOIN persona ON carrito_persona.num_doc=persona.num_doc WHERE correo_electronico='$id'");
                                            if($result){
                                                $datos_car=mysqli_fetch_assoc($result);
                                                $cod_carrito=$datos_car['cod_carrito'];
                                            
                                                if($cod_carrito!==null){
                                            
                                                    $sqlfc="INSERT INTO factura (fecha_factura,metodo_pago,num_doc,cod_reserva,cod_carrito) VALUES('$fecha_factura','$MetodoPago','$num_doc','$cod_reserva','$cod_carrito')";

                                                    $generar_fac1=mysqli_query($bd,$sqlfc);
                                                    $cod_fac=mysqli_insert_id($bd);
                                                    
                                                    $sql_cantidad="SELECT COUNT(*) FROM persona JOIN carrito_persona ON persona.num_doc=carrito_persona.num_doc WHERE persona.num_doc='$num_doc'";
                                                    $rconsulta=mysqli_query($bd,$sql_cantidad);
                                                    $cantidad=mysqli_fetch_assoc($rconsulta);
                                                    $cantidad=$cantidad["COUNT(*)"];
                                                    
                                                    $generar_facturac=mysqli_query($bd,"INSERT INTO detalle_factura(cod_factura,cod_carrito,cantidad_serv_adquiridos) VALUES('$cod_fac','$cod_carrito','$cantidad');");
                                                    if($generar_facturac){
                                                        echo "<script type='text/javascript'>
                                                        alert ('Reserva generada exitosamente, los servicios del carrito fueron añadidos. Puede consultar el valor total en ver factura');
                                                        window.location='ver_reservas.php';
                                                        </script>";
                                                    }
                                                    }
                                                    else{
                                                        $sqlf="INSERT INTO factura (fecha_factura,metodo_pago,num_doc,cod_reserva) VALUES('$fecha_factura','$MetodoPago','$num_doc','$cod_reserva')";
                                                    
                                                        $generar_fac=mysqli_query($bd,$sqlf);
                                                    
                                                        $cod_fac=mysqli_insert_id($bd);
                                                    
                                                        $generar_factura=mysqli_query($bd,"INSERT INTO detalle_factura(cod_factura) VALUES('$cod_fac');");
                                                        if($generar_factura){
                                                            echo "<script type='text/javascript'>
                                                            alert ('Reserva generada exitosamente...');
                                                            window.location='ver_reservas.php';
                                                            </script>";
                                                        }
                                                }
                                                }
                                                }
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