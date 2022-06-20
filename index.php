<?php
  session_start();
  include "app/conexion/Conexion.php";
  $bd = new Conexion;
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
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">
  
    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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

    <!-- Header Carousel -->
    <header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide One');"></div>
                <div class="carousel-caption">
                    <h2>Caption 1</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide Two');"></div>
                <div class="carousel-caption">
                    <h2>Caption 2</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide Three');"></div>
                <div class="carousel-caption">
                    <h2>Caption 3</h2>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </header>

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
            <h2 class="page-header">Subastas Recientes</h2>
          </div>
          <?php
            //realizacion de consulta para generar tabla de subastas
                $query = "SELECT P.id_producto, P.producto, P.descripcion, P.foto, C.categoria, S.id_subasta, S.fecha_subasta , S.fecha_limite, S.estatus_subasta,
								S.oferta_inicial, S.oferta_final FROM sub_productos as P, sub_categorias as C, sub_subastas as S where P.id_categoria=C.id_categoria and P.id_producto=S.id_producto and S.estatus_subasta=1;";
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
                        <img style="height:250px;" src="app/producto/img/<?php echo $row["foto"];?>" alt="<?php echo $row["producto"];?>">
                        <div class="caption">
                            <h4 class="pull-right"><?php echo "$".$row["oferta_inicial"]." - $".$row["oferta_final"];?></h4>
                            <h4><a href="app/subasta.php?id_subasta=<?php echo $row["id_subasta"];?>"><?php echo $row["producto"];?></a>
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
                    echo "<center style='color:red;'>Aun no se agregan subastas. vuelva mas tarde :)</center>";
                }
          ?>
          

          

      </div>
      <!-- /.row -->

      <?php include "footer.php"; ?>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>
