<?php
  session_start();
  include "conexion/Conexion.php";
  $bd = new Conexion;
if(!isset($_GET["id"])){
	echo "<script>location.href='../index.php'</script>";
}else{
  $strWhere="";
  if ($_GET['id']!= "" )
	{$strWhere.=" and C.id_categoria=".$_GET['id']."";} //pon el campoooo, ya! ok espera

  //realizacion de consulta para generar los datos de las categorias
	$resultSet = $bd->select("SELECT * FROM sub_categorias ;");
	//obtenemos resultado de la consulta
  $categorias = mysqli_fetch_array($resultSet);
	
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Home - SUBASTAME</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/modern-business.css" rel="stylesheet">
  
    <!-- Custom CSS -->
    <link href="../css/shop-homepage.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
        <?php
          if(!isset($_SESSION["id_usuario"])){?>
      <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Bienvenido a SUBASTAME!
                </h1>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-fw fa-check"></i>Registrate es facil</h4>
                    </div>
                    <div class="panel-body">
                        <p>Regístrate en 30 segundos, y disfruta de las oportunidades que te brindará tu comunidad. Si ganas la subasta del producto elegido, lo recibes donde nos digas, en pocos días, con todas las garantías.</p>
                        <a href="#" class="btn btn-default">Click aqui!</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-fw fa-gift"></i> Subastas &amp; Ventas online</h4>
                    </div>
                    <div class="panel-body">
                        <p>En SUBASTAME realizarás la compra, combinando la dinámica y ventajas de las subastas convencionales con la compra online.</p>
                       <br><br><a href="carrito.php" class="btn btn-default">Ver carrito</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-fw fa-compass"></i> Facil de usar</h4>
                    </div>
                    <div class="panel-body">
                        <p>Solo necesitas seleccionar algun articulo de aqui abajo, bastara con dar click en el botón azul "ver" y te enviara directamente a la subasta. estando ya en la subasta ocuparas estar registrado para poder ofertar.
                      la mejor oferta se lleva el producto. asi que, ¡Que estas esperando! a ofertar!</p>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
      <?php      
          }
        ?>
        <!-- subastas Section -->
        <div class="row">
          <div class="col-lg-12">
                <h1 class="page-header">Busqueda por
                    <small>Categoria</small>
                </h1>
                <ol class="breadcrumb">
                  <?php 
                  foreach($categorias as $categoria){ 
                    if($_GET["id"] == $categoria["id_categoria"]){ ?>
                      <li  class="active"><?php echo $categoria["categoria"]; ?></li>
                  <?php
                    }else{
                  ?>
                      <li><a href="subastas.php?id=<?php echo $categoria["id_categoria"]; ?>" ><?php echo $categoria["categoria"]; ?></a></li>
                  <?php 
                    }
                  }
                  ?>
                    
                    
                </ol>
            </div>
          <?php
            //realizacion de consulta para generar tabla de subastas
                $query = "SELECT P.id_producto, P.producto, P.descripcion, P.foto, C.categoria, S.id_subasta, S.fecha_subasta , S.fecha_limite, S.estatus_subasta,
								S.oferta_inicial, S.oferta_final FROM sub_productos as P, sub_categorias as C, sub_subastas as S where P.id_categoria=C.id_categoria and P.id_producto=S.id_producto and S.estatus_subasta=1 ".$strWhere.";";
                //obtenemos resultado de la consulta
                $resultSet = $bd->select($query);
          
                if($resultSet->num_rows > 0){
                  while($row = mysqli_fetch_array($resultSet)){
                    //obtenemos fecha del servidor
                    $fecha_servidor = date("Y-m-d H:i:s");
                    //declaramos el primer valor de fecha y tiempo
                    $datetime1 = date_create($fecha_servidor);
                    //declaramos el segundo valor de fecha y tiempo
                    $datetime2 = date_create($row["fecha_limite"]);
                    //sacamos la diferencia entre las 2 fechas la limite de la bd y la del servidor
                    $interval = date_diff($datetime1, $datetime2);
                    //le damos formato al intervalo que nos regreso la diferencia
                    $fecha_restantes = $interval->format('%R%d días %R%h horas %R%i min');
          ?>
                    <div class="col-sm-4 col-lg-4 col-md-4">
                      <div class="thumbnail">
                        <img style="height:250px;" src="producto/img/<?php echo $row["foto"];?>" alt="<?php echo $row["producto"];?>">
                        <div class="caption">
                            <h4 class="pull-right"><?php echo "$".$row["oferta_inicial"]." - $".$row["oferta_final"];?></h4>
                            <h4><a href="subasta.php?id_subasta=<?php echo $row["id_subasta"];?>"><?php echo $row["producto"];?></a>
                            </h4>
                            <p><?php echo $row["descripcion"];?></p>
                        </div>
                        <div class="ratings">
                            <p class="pull-right"><?php echo $fecha_restantes;?></p>
                            <p>
                              <?php echo $row["categoria"];?>
                            </p>
                        </div>
                      </div>
                    </div>
          <?php
                    
                  }
                  
                }else if($resultSet->num_rows == 0){
                    echo "<center style='color:red;'>no se encontraron subastas con esa categoria vuelva mas tarde :)</center>";
                }
          ?>
          

          

      </div>
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
	
		<!-- verificador js para eliminar subastas caducadas -->
    <script src="../js/verificador.js"></script>  
  
	
    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>
<?php
		 }
?>