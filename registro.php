<?php 
  session_start();
include "app/conexion/Conexion.php";
$bd = new Conexion;
  if(!isset($_SESSION["id_usuario"])){
    /*$time = time();
    echo "<br/>";
    echo $time;
    echo "<br/>";
    echo date("d-m-Y (H:i:s)", -3600);
    echo "<br/>";
    echo date("d-m-Y (H:i:s)", 0);
    echo "<br/>";
    echo date("d-m-Y (H:i:s)", 3600);
    echo "<br/>";
    echo date("Y-m-d (H:i:s)", $time);
    echo "<br/>";
    echo date("Y-m-d ", $time);
    echo "<br/>";
    echo ("Según el servidor la hora actual es: ". date("H:i:s", $time));*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Registro</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="login.css">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet" type="text/css">

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

    if(isset($_POST["registrar"])){

        $nombre=$_POST['nombre'];
        $paterno=$_POST['paterno'];
        $materno=$_POST['materno'];
        $correo=$_POST['correo'];
        $user=$_POST['user'];
        $pass1=$_POST['pass1'];
        $pass2=$_POST['pass2'];

        if ($pass1 == $pass2 && $pass1 != "") {
            
            $query = "SELECT * FROM usuario WHERE user='".$user."'";
            $result = $bd->select($query);

            if ($result->num_rows > 0) {
                $message = "<center>usuario ya registrado</center>";
            }else{
                
                $insert = "INSERT INTO sub_usuarios(nombre, ap_p, ap_m, correo, usuario, pass) values
                ('$nombre','$paterno','$materno','$correo','$user','".base64_encode($pass1)."');";

                $result = $bd->query($insert);

                if ($result == true){

                    $result = $bd->select("select id_usuario from sub_usuarios where usuario='".$user."'");
                    $row = $result->fetch_assoc();
                    $id = $row["id_usuario"];
                    $nombre = $row["usuario"];

                    $_SESSION['id_usuario']=$id;
                    $_SESSION["usuario"] = $nombre;
                    header("Location: index.php");
                }else {
                  $message = "<center>Registro fallado, intentalo mas tarde...</center>";
                }
            }
        }else{
          $message = "<center style='color:red;'>Verifique las contraseñas.. </center>";
        }

    }

?>

    <div class="container">    
        <div id="loginbox" style="margin-top:0px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" style="border-color: #e0e0e0">
                    <div class="panel-heading" style="background-color: #e0e0e0;">


                        <div class="panel-title">Registrarte</div>

                        <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="index.php">Visitar pagina como usuario anonimo</a></div>

                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form" method="post" action="">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="nombre" value="" required="" placeholder="Nombre">  
                                        <input id="login-username" type="text" class="form-control" name="paterno" value="" required="" placeholder="Apellido Paterno">
                                        <input id="login-username" type="text" class="form-control" name="materno" value="" required="" placeholder="Apellido Materno">   
                                        <input id="login-username" type="text" class="form-control" name="correo" value="" required="" placeholder="Correo">                                 
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group"> 
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="user" value="" required="" placeholder="Usuario">  
                                        <input id="login-password" type="password" class="form-control" name="pass1" required="" placeholder="Nueva contraseña">
                                        <input id="login-password" type="password" class="form-control" name="pass2" required="" placeholder="Verificar contraseña">
                                    </div>


                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
                                      <?php if(isset($message)){ echo $message; }?>
                                      <input class="btn btn-success" type="submit" value="Registrarme" name="registrar">
                                      </input>
                                      
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            ¿Ya tienes una cuenta?
                                        <a href="login.php" >
                                            Inicia sesion aqui
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