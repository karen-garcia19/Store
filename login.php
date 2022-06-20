<?php
  session_start();
	include "app/conexion/Conexion.php";
	$bd= new Conexion;
  if(!isset($_SESSION["id_usuario"])){
?>
<html>
<head>
    <title>Iniciar sesion</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="login.css">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<?php  

    if(isset($_POST["entrar"])){
 
		if(!empty($_POST['username']) && !empty($_POST['password'])) {

			$username=$_POST['username'];
			$password=$_POST['password'];
			 echo $username;
			echo $password;
			$query = "SELECT * FROM sub_usuarios WHERE usuario='".$username."' AND pass='".base64_encode($password)."'";
			echo $query;
			$result = $bd->select($query);

			if ($result->num_rows > 0) {
		    	while ($row = mysqli_fetch_array($result)) {
		    		$user = $row["usuario"];
		    		$pass = $row["pass"];
		    		$id = $row["id_usuario"];
						
		    	}
				
				if($username == $user && base64_encode($password) == $pass){
							$_SESSION['id_usuario']=$id;
							$_SESSION['usuario']=$user;
					 		echo "<script>location.href='index.php';</script>";
						}

		    	

		    }else{
				$message = "Nombre de usuario ó contraseña invalida!";
			}

		}else{
		 	$message = "Todos los campos son requeridos!";
		}
	}

?>

    <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" style="border-color: #e0e0e0">
                    <div class="panel-heading" style="background-color: #e0e0e0;">
                        <div class="panel-title">Iniciar sesion</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">¿Olvidaste tu contraseña?</a></div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form" method="post">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="usuario">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="contraseña">
                                    </div>
                      


                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
																		<?php 
																		if(isset($message)){
																			echo "<center><label style='color:red;'>$message</label></center><br>";
																		}else{}?>

                                    <input class="btn btn-success" type="submit" value="Entrar" name="entrar"></input>
                                      
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            ¿No tienes una cuenta?
                                        <a href="registro.php" >
                                            Registrate aqui
                                        </a>
                                        </div>
                                    </div>
                                </div>    
                            </form>     



                        </div>                     
                    </div>  
              </div>
         </div> 
    </div>
    

</body>
</html>
<?php
}else{
    echo "<script>location.href='index.php';</script>";
  }
?>