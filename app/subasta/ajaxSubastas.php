<?php
  session_start();
  include "Subasta.php";

  if(!isset($_POST)){
    echo "A ocurrido un error al agregar usuario!"; 
  }else{
      if($_POST["accion"] == "insertar"){
        $fecha_subasta= date("Y-m-d H:i:s");
        $fecha_fin = $_POST["date_fin"]." ".$_POST["time_fin"];
        $subasta = new Subasta($fecha_subasta,$fecha_fin,$_POST["of_ini"],$_POST["of_fin"],$_POST["id_p"],$_SESSION["id_usuario"]);
        $mensaje = $subasta->agregar($subasta);

        echo $mensaje;
      }
    }
?>