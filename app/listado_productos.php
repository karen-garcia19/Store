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

    <title>Listado de productos</title>

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
         <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-12">

                <h3 class="page-header">Productos</h3>
                <?php
                //realizacion de consulta para generar tabla de productos
                $query = "SELECT P.id_producto, P.producto, P.descripcion, P.foto, C.categoria FROM sub_productos as P, sub_categorias as C where P.id_categoria=C.id_categoria and P.id_usuario=".$_SESSION["id_usuario"].";";
                //obtenemos resultado de la consulta
                $resultSet = $bd->select($query);
                ?>
                <table class="table table-condensed">
                  <thead>
                    <th>#</th>
                    <th>producto</th>
                    <th>desc</th>
                    <th>categoria</th>
                    <th></th>
                  </thead>
                  <tbody>
                    <?php
                      while($row = mysqli_fetch_array($resultSet)){?>
                    <tr>
                      <td><?php echo $row["id_producto"];?></td>
                      <td><?php echo $row["producto"];?></td>
                      <td><?php echo $row["descripcion"];?></td>
                      <td><?php echo $row["categoria"];?></td>
                      <td>
                        <label>
                          <a href="agregar_subasta.php?id_producto=<?php echo $row["id_producto"];?>&nombre=<?php echo $row["producto"]?>" class='btn btn-warning btn-xs' >Subastar</a>
													<a onclick="eliminar(<?php echo $row["id_producto"];?>,'<?php echo $row["producto"];?>','<?php echo $row["foto"];?>')" class='btn btn-danger btn-xs' >Eliminar</a>
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