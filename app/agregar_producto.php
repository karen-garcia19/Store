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

    <title>Alta de productos</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- drag and drop-->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
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
						<div id="aviso" class="alert alert-success" style="display:none;"></div>
             <div class="col-md-2">
                 <br>
                 <br>
                 <br>
                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Opciones</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="listado_productos.php">Agregar subasta</a></li>
																<li><a href="agregar_categoria.php">Agregar categoria</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
         
            <!-- Blog Entries Column -->
            <div class="col-md-10">

                <h3 class="page-header">Alta de productos</h3>
                
                <form id="form-producto" enctype="multipart/form-data" name="sentMessage" method="post" action=""  novalidate>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Nombre del producto:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required data-validation-required-message="Favor de teclear el nombre del producto">
                            <p class="help-block"></p>
                        </div>
                    </div>
                  <div class="form-group">
                    <label for="categoria">Seleccione una categoria:</label><br>
                    <select class="form-control" name="categoria" id="categoria">
					<option value="s/v">Selecciona una opcion</option>
					<?php  

						$categorias = $bd->select("select * from sub_categorias");

						if ($categorias->num_rows > 0) {

					    	while ($row = $categorias->fetch_assoc()) {
					    		$cat = $row["categoria"];
					    		$id_cat= $row["id_categoria"];
					    		echo "<option value='$id_cat'>$cat</option>";
					    	}
					    }else{
					    	echo "<option value='s/c'>No existen categorias aun</option>";
					    }

					?>
                    </select></div>
                    <div class="form-group">
                        <label for="foto">Fotografia:</label>
                        <input id="foto" type="file" class="file" accept="image/*" name="foto">
                    </div><br>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Descripcion:</label>
                            <textarea rows="10" cols="100" class="form-control" id="descripcion" name="descripcion" required data-validation-required-message="Please enter your message" maxlength="999" style="resize:none"></textarea>
                        </div>
                    </div>
                    <div id="success"></div>
                    <!-- For success/fail messages -->
                    <button type="submit" class="btn btn-primary" id="enviar" name="enviar">Agregar</button>
                </form>
               
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
  
	
	<script src="../js/fileinput.min.js" type="text/javascript"></script>


</body>

</html>