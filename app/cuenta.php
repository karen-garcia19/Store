<?php 
	
	session_start();
	include("conexion/Conexion.php");
	$bd = new Conexion();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Listado de Subastas</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

     <!-- Navigation -->
    <?php include "header.php";?>
    <!-- Page Content -->
    <div class="container">
        <br>
			<?php
                  //Contador para las subastas disponibles
                  $res_count=$bd->select("SELECT count(*) as total from sub_subastas where estatus_subasta=1");
                  $data=mysqli_fetch_array($res_count);
                  $count_subastas = $data['total'];
                ?>
				<div class="row">
					<div class="col-lg-3 col-md-6">
							<div class="panel panel-primary">
									<div class="panel-heading">
											<div class="row">
													<div class="col-xs-3">
															<i class="fa fa-th-list fa-5x"></i>
													</div>
													<div class="col-xs-9 text-right">
															<div class="huge"><?php echo $count_subastas; ?></div>
															<div>Total de Subastas Activas</div>
													</div>
											</div>
									</div>
									<a href="subastas.php?id=1">
											<div class="panel-footer">
													<span class="pull-left">Ver detalles</span>
													<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
													<div class="clearfix"></div>
											</div>
									</a>
							</div>
					</div>
					<?php
						 //Contador para productos en mi cesta
                  $res_count=$bd->select("SELECT count(*) as total from sub_cesta where id_usuario=".$_SESSION["id_usuario"]);
                  $data=mysqli_fetch_array($res_count);
                  $count_cesta = $data['total'];
					?>
					<div class="col-lg-3 col-md-6">
							<div class="panel panel-green">
									<div class="panel-heading">
											<div class="row">
													<div class="col-xs-3">
															<i class="fa fa-shopping-cart fa-5x"></i>
													</div>
													<div class="col-xs-9 text-right">
														<div class="huge"><?php echo $count_cesta; ?></div>
														<div>Mi cesta</div>
													</div>
											</div>
									</div>
									<a href="carrito.php">
											<div class="panel-footer">
													<span class="pull-left">Ver detalles</span>
													<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
													<div class="clearfix"></div>
											</div>
									</a>
							</div>
					</div>
					<?php
						 //Count para las subastas propias activas
                  $res_count=$bd->select("SELECT count(*) as total from sub_categorias");
                  $data=mysqli_fetch_array($res_count);
                  $count_cat = $data['total'];
					?>
					<div class="col-lg-3 col-md-6">
							<div class="panel panel-yellow">
									<div class="panel-heading">
											<div class="row">
													<div class="col-xs-3">
															<i class="fa fa-unlock fa-5x"></i>
													</div>
													<div class="col-xs-9 text-right">
														<div class="huge"><?php echo $count_cat; ?></div>
														<div>Categorias Disponibles</div>
													</div>
											</div>
									</div>
									<a href="subastas.php?id=2">
											<div class="panel-footer">
													<span class="pull-left">Ver detalles</span>
													<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
													<div class="clearfix"></div>
											</div>
									</a>
							</div>
					</div>
					<?php
						//Count para las subastas propias cerradas
                  $res_count=$bd->select("SELECT count(*) as total from sub_subastas where estatus_subasta=0");
                  $data=mysqli_fetch_array($res_count);
                  $count_subastas_inactivas = $data['total'];
					?>
					<div class="col-lg-3 col-md-6">
							<div class="panel panel-red">
									<div class="panel-heading">
											<div class="row">
													<div class="col-xs-3">
															<i class="fa fa-lock fa-5x"></i>
													</div>
													<div class="col-xs-9 text-right">
														<div class="huge"><?php echo $count_subastas_inactivas; ?></div>
														<div>Total de Subastas cerradas</div>
													</div>
											</div>
									</div>
									<a href="subastas_cerradas.php">
											<div class="panel-footer">
													<span class="pull-left">Ver detalles</span>
													<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
													<div class="clearfix"></div>
											</div>
									</a>
							</div>
					</div>
			</div>
         <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-12">

                <h3 class="page-header">Subastas realizadas por <?php echo $_SESSION["usuario"];?></h3>
                <?php
                //realizacion de consulta para generar tabla de subastas
                $query = "SELECT P.id_producto, P.producto, C.categoria, S.id_subasta, S.fecha_subasta , S.fecha_limite, S.estatus_subasta
								FROM sub_productos as P, sub_categorias as C, sub_subastas as S where P.id_categoria=C.id_categoria and P.id_producto=S.id_producto and S.id_usuario=".$_SESSION["id_usuario"].";";
                //obtenemos resultado de la consulta
                $resultSet = $bd->select($query);
                ?>
                <table class="table table-condensed">
                  <thead>
                    <th>#</th>
                    <th>producto</th>
                    <th>categoria</th>
                    <th>fecha inicio</th>
                    <th>fecha final</th>
										<th>Estatus</th>
                  </thead>
                  <tbody>
                    <?php
                      while($row = mysqli_fetch_array($resultSet)){?>
                    <tr>
                      <td><?php echo $row["id_subasta"];?></td>
                      <td><?php echo $row["producto"];?></td>
                      <td><?php echo $row["categoria"];?></td>
                      <td><?php echo $row["fecha_subasta"];?></td>
											<td><?php echo $row["fecha_limite"];?></td>
											<td><?php echo $row["estatus_subasta"];?></td>
                      <td>
                        <label>
                          <a href="subasta.php?id_subasta=<?php echo $row["id_subasta"];?>" class='btn btn-warning btn-xs' >Ver</a>
													<a onclick="eliminarSubasta(<?php echo $row["id_producto"];?>,'<?php echo $row["producto"];?>','<?php echo $row["foto"];?>',<?php echo $row["id_subasta"];?>)" class='btn btn-danger btn-xs' >Eliminar</a>
                        </label>
                      </td>
                    </tr>
                    <?php    
                      }
                    ?>
                  </tbody>
                </table>
                
        <!-- /.row -->
            
            </div>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            
                    <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Subastame 2016 Todos los Derechos Reservados.</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
	
	<!--JavaScript de administracion productos-->
    <script src="../js/productos.js"></script>
	
	<!-- verificador js para eliminar subastas caducadas -->
    <script src="../js/verificador.js"></script>  
  

</body>

</html>
