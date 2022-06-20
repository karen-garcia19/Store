<?php
  session_start();
  include "Producto.php";

  if(!isset($_POST)){
    echo "A ocurrido un error al agregar usuario!"; 
  }else{
    if(!isset($_POST["accion"])){
      $producto = new Producto($_POST["nombre"],$_POST["descripcion"],$_FILES["foto"]["name"],$_POST["categoria"],$_SESSION["id_usuario"]);
      $mensaje = $producto->agregar($producto,$_FILES["foto"]["tmp_name"]);

      echo $mensaje;
    }else{
      if($_POST["accion"] == "eliminar"){
        $producto = new Producto("","","","","");
        $mensaje = $producto->eliminar($_POST["id_producto"],$_POST["foto"]);

        echo $mensaje;
      }
    }
    
  }
?>