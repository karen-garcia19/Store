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

    <title>Agregar Categorias</title>

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

                <h3 class="page-header">Alta de categoria</h3>
                
                <form enctype="multipart/form-data" name="sentMessage" id="contactForm" method="post" action=""  novalidate>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Nombre de la categoria:</label>
                            <input type="text" class="form-control" id="categoria" name="categoria" required >
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Descripcion:</label>
                            <textarea rows="10" cols="100" class="form-control" id="descripcion" name="descripcion" required maxlength="999" style="resize:none"></textarea>
                        </div>
                    </div>
                    <div id="success"></div>
                    <!-- For success/fail messages -->
                    <button type="submit" class="btn btn-primary" id="enviar" name="enviar">Agregar</button>
                </form>
                <?php
                    if(isset($_POST["enviar"])){
                            
                        $nombre = $_POST["categoria"];
        			    $descripcion = $_POST["descripcion"];
                            
        				$query="INSERT INTO sub_categorias(categoria,descripcion) 
        				values('$nombre','$descripcion');";
                         $result=$bd->query($query);
                    
                        if ($result == true) {
                        
                            echo "<script> alert('Se ha agregado la categoria');</script>";                                
    				    }else{
    					    echo "<script> alert('Problemas al agregar tu producto');</script>";
    				    }
                    }
                ?>
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