<?php 
	
	session_start();
	include("conexion/Conexion.php");
	$bd = new Conexion();
if(!isset($_GET["id_subasta"])){
	echo "<script>location.href='../index.php'</script>";
}else{
	$max =0;
	$id_sub =$_GET["id_subasta"];
	//realizacion de consulta para generar los datos de la subasta
	$query = "SELECT * FROM sub_productos as P, sub_categorias as C, sub_subastas as S, sub_usuarios as U where P.id_categoria=C.id_categoria and P.id_producto=S.id_producto and S.id_usuario=U.id_usuario and S.id_subasta=".$_GET["id_subasta"].";";
	//obtenemos resultado de la consulta
	$resultSet = $bd->select($query);
	//creamos el arreglo que utilizaremos para mostrar los datos de la subasta
	$subasta = mysqli_fetch_array($resultSet);
	//realizacion de consulta para obtener la suma de ofertas que tiene una subasta
	$query2 = "SELECT sum(id_usuario) as sum FROM sub_ofertas_has_clientes where id_subasta=".$_GET["id_subasta"].";";
	//obtenemos resultado de la consulta
	$resultSet2 = $bd->select($query2);
	//arreglo donde almacenaremos el numero de ofertas
	$result = mysqli_fetch_array($resultSet2);
	//variable suma = al arreglo que contiene nuestra suma
	$sum = $result["sum"];
	//obtenemos la oferta mas alta para validar el inptu de oferta y que no pueda dar una oferta mas baja que la que ya hay actualmente
	$res = $bd->select("SELECT * FROM sub_ofertas_has_clientes WHERE id_subasta='$id_sub' ORDER BY id_oferta DESC LIMIT 0, 1");
	if($res->num_rows > 0){
		$maxarr = mysqli_fetch_array($res);
		$max = $maxarr["cantidad"];
	}else if($res->num_rows == 0){
		$max = $subasta["oferta_inicial"];
	}
       
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
	<script>
    setInterval("tiempo()",1000); // Ejecuto la acción cada segundo

    function tiempo(){
    	$.post("tiempo.php",{tiempo_limite:$("#tiempo_limite").val()}, function(data){
      	data = JSON.parse(data);
				if(data.bandera === 'parar'){
					$("#tiempo").html(data.fecha);
					document.getElementById("comprar").setAttribute("disabled", "disabled");
					document.getElementById("ofertar").setAttribute("disabled", "disabled");
					document.getElementById("oferta").setAttribute("disabled", "disabled");
					
				}else if(data.bandera === 'seguir'){
					$("#tiempo").html(data.fecha);
				}
     	});

    }
		
		function mostrarOfertas(){
			$.post("ofertas.php",{id_subasta:$("#id_subasta").val()}, function(data){
				$("#oferts").html(data);
     	});
		}
  </script>

</head>

<body onload="mostrarOfertas()">

     <!-- Navigation -->
    <?php include "header.php";?>
    <!-- Page Content -->
    <div class="container">
        <br><input type="hidden" value="<?php echo $_GET["id_subasta"]; ?>" id="id_subasta">
			<h3 class="page-header">Subasta <?php echo $subasta["producto"]?> by <?php echo $subasta["usuario"]?></h3><h4>Tiempo restante <label id="tiempo"></label></h4>
         <div class="row">
            <div class="col-md-12">
								<input type="hidden" value="<?php echo $subasta["fecha_limite"]?>" id="tiempo_limite">
                <div class="thumbnail">
                    <img class="img-responsive" style="height:400px;" src="producto/img/<?php echo $subasta["foto"];?>" alt="">
                    <div class="caption-full">
                        <h4 class="pull-right">Precio minimo $<?php echo $subasta["oferta_inicial"]?> - Precio maximo $<?php echo $subasta["oferta_final"]?></h4>
                        <h4><a href="#"><h3>
													<?php echo $subasta["producto"]?>
													</h3></a>
                        </h4>
                        <p><?php echo $subasta[2]?></p>
                    </div>
                    <div class="ratings">
                        <p class="pull-right"><?php if($sum != null){ echo "<b style='color:red;'>".$sum." ofertas</b>"; }else{ echo "<b style='color:red;'>0 ofertas</b>"; } ?></p>
                        <p>
                            <b><?php echo $subasta["categoria"]?></b>
                        </p>
                    </div>
                </div>

                <div class="well">
									<div class="row">
										<div class="col-md-6">
											<h4>
												<b>Ofertas Para <?php echo $subasta["producto"]?></b>
											</h4>
										</div>
										<?php if(isset($_SESSION["id_usuario"])){ ?>
										<div class="col-md-6">
											<?php if($subasta["estatus_subasta"] == "1"){ ?>
											<div class="row">
												<div class="col-md-3"></div>
												<div class="col-md-6">
													<form action="" method="post" class="form-inline">
														<div class="form-group">
															<div class="input-group">
																<div class="input-group-addon">$</div>
																<input type="number" id="oferta" name="oferta" class="form-control" min="<?php echo $max; ?>" max="<?php echo $subasta["oferta_final"];?>" required>
															</div>
														</div>
														<input type="hidden" name="id_subasta" value="<?php echo $_GET["id_subasta"]; ?>" id="id_subasta">
														<input type="hidden" name="precio_limite" value="<?php echo $subasta["oferta_final"]; ?>" >
														<button class="form-control" type="submit" name="ofertar" class="btn btn-warning" id="ofertar">Ofertar</button>
													</form>
												</div>
												<div class="col-md-3">
													<form action="" method="post" class="form-inline">
														<input type="hidden" name="oferta_directa" value="<?php echo $subasta["oferta_final"];?>" >
														<input type="hidden" name="id_subasta_directo" value="<?php echo $_GET["id_subasta"]; ?>" id="id_subasta">
														<button type="submit" name="comprar" class="btn btn-success" id="comprar" >Lo quiero</button>
													</form>
												</div>
											</div>
											<?php }else{ ?>
											<div class="row">
												<div class="col-md-3"></div>
												<div class="col-md-6">
													<form action="" method="post" class="form-inline">
														<div class="form-group">
															<div class="input-group">
																<div class="input-group-addon">$</div>
																<input type="number" id="oferta" class="form-control" min="<?php if($sum != null){  }else{ echo $subasta["oferta_inicial"]; } ?>" max="<?php echo $subasta["oferta_final"];?>" required>
															</div>
														</div>
														<input type="hidden" name="id_subasta" value="<?php echo $_GET["id_subasta"]; ?>" id="id_subasta">
														<button type="submit" name="ofertar" class="btn btn-warning" id="ofertar">Ofertar</button>
													</form>
												</div>
												<div class="col-md-3"><button type="button" name="comprar" class="btn btn-success" id="comprar" disabled>Lo quiero</button></div>
			 								</div>
										<?php	} 
											}?>
										</div>
										
									</div>
									<div id="oferts">
                	</div>
									<?php
										if(isset($_POST["comprar"])){
											//obtemnemos valores por post
											$idsubasta = $_POST["id_subasta_directo"];
											$idusuairo = $_SESSION["id_usuario"];
											$cantidad = $_POST["oferta_directa"];
											$fecha = date("Y-m-d H:i:s");
											
											//creamos objeto conexion
											$bd = new Conexion();
											//insertamos la oferta
											$resultSet = $bd->query("insert into sub_ofertas_has_clientes(id_subasta,id_usuario,cantidad,fecha_oferta,estado) values($idsubasta,$idusuairo,'$cantidad','$fecha',1);");
											//verificamos el insert
											if($resultSet){
												//realizamos una actualizacion al campo estatus de la subasta
												$resultado = $bd->query("UPDATE sub_subastas SET estatus_subasta=0 WHERE id_subasta=$idsubasta;");
												//verificamos si fue exitoso
												if($resultado){
													//insertamos en la cesta el usuario que gano la subasta
													$estado = $bd->query("INSERT INTO sub_cesta(id_subasta,id_usuario,oferta_final) VALUES($idsubasta,$idusuairo,'$cantidad')");
													echo "<script>alert('¡Felicidades has ganado la subasta!')</script>";
												}
											}
										}
	
										if(isset($_POST["ofertar"])){
											//obtemnemos valores por post
											$idsubasta = $_POST["id_subasta"];
											$idusuairo = $_SESSION["id_usuario"];
											$cantidad = $_POST["oferta"];
											$fecha = date("Y-m-d H:i:s");
											if($_POST["precio_limite"] != $cantidad){
												//creamos objeto conexion
												$bd = new Conexion();
												//insertamos la oferta
												$resultSet = $bd->query("insert into sub_ofertas_has_clientes(id_subasta,id_usuario,cantidad,fecha_oferta,estado) values($idsubasta,$idusuairo,'$cantidad','$fecha',0);");
												//verificamos el insert
												if($resultSet){
													echo "<script>alert('¡Felicidades oferta realizada!')</script>";
												}else{
													echo "<script>alert('lo sentimos algo ocurrio mal!')</script>";
												}
											}else{
												//creamos objeto conexion
												$bd = new Conexion();
												//insertamos la oferta
												$resultSet = $bd->query("insert into sub_ofertas_has_clientes(id_subasta,id_usuario,cantidad,fecha_oferta,estado) values($idsubasta,$idusuairo,'$cantidad','$fecha',1);");
												//verificamos el insert
												if($resultSet){
													//realizamos una actualizacion al campo estatus de la subasta
													$resultado = $bd->query("UPDATE sub_subastas SET estatus_subasta=0 WHERE id_subasta=$idsubasta;");
													//verificamos si fue exitoso
													if($resultado){
														//insertamos en la cesta el usuario que gano la subasta
														$estado = $bd->query("INSERT INTO sub_cesta(id_subasta,id_usuario,oferta_final) VALUES($idsubasta,$idusuairo,'$cantidad')");
														echo "<script>alert('¡Felicidades has ganado la subasta!')</script>";
													}
												}
											}
											
										}
									?>

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
			
			

</body>

</html>
<?php
		 }
?>