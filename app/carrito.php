<?php 
	
	session_start();
	error_reporting(0);	
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

    <title>Cesta</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/modern-business.css" rel="stylesheet">

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

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Cesta de <?php if(!isset($_SESSION["usuario"])){}else{ echo $_SESSION["usuario"];} ?>
                </h1>
            </div>
        
            
            <?php
							//arreglo donde estaran los items
							$items = array();
							$id_subasta = array();
							$oferta_final = array();
							//query que devuelve lo que hay en la cesta del usuario
							$query = "SELECT * FROM sub_cesta WHERE id_usuario=".$_SESSION["id_usuario"];
              //ejecutamos la consulta
							$result = $bd->select($query);
							//verificamos si de vuelve algun registro nuestra consulta, sino mandamos mensaje de 0 items
              if ($result->num_rows > 0) {
								
								while ($row = $result->fetch_assoc()){
										$id_subasta[] = $row["id_subasta"];
										$oferta_final[] = $row["oferta_final"];
								}
								
								for($i=0;$i<count($id_subasta);$i++){
									//realizacion de consulta para generar tabla de subastas
                	$query = "SELECT * FROM
									sub_productos as P, sub_categorias as C, sub_usuarios as U, sub_subastas as S where P.id_categoria=C.id_categoria and P.id_producto=S.id_producto and U.id_usuario=S.id_usuario and S.id_subasta=".$id_subasta[$i].";";
                	//obtenemos resultado de la consulta
               		$resultSet = $bd->select($query);
									
									while ($row = mysqli_fetch_array($resultSet)){
										$producto = array(
											"producto" => $row["producto"],
											"categoria" => $row["categoria"],
											"precio" => $oferta_final[$i],
											"subastador" => $row["usuario"]
										);
									}
									$items[]=$producto;
								}
								
								//print_r($items);
							}else if($result->num_rows == 0){
								echo "<center style='color:red;'>No tines productos en tu carrito</center>";
							}
					
            ?>
					<table class="table table-condensed">
						<thead>
							<th>producto</th>
							<th>categoria</th>
							<th>Precio</th>
							<th>subastador</th>
						</thead>
						<tbody>
							<?php
								foreach($items as $item){?>
							<tr>
								<td><?php echo $item["producto"];?></td>
								<td><?php echo $item["categoria"];?></td>
								<td><?php echo $item["precio"];?></td>
								<td><?php echo $item["subastador"];?></td>
							</tr>
							<?php    
								}
							?>
						</tbody>
					</table>
        </div>
				
				<?php 
            if (!isset($_SESSION["id_usuario"])) { 
         ?>
        <h4 style='color:red;'>¡Para poder comprar necesitas ingresar!</h4>
        <a class='btn btn-primary' href='login.php'>Iniciar sesion</a>
				<?php } ?>
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
  

</body>

</html>