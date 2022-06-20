<?php
  include "conexion/Conexion.php";
  if(isset($_POST["revisar"])){
    //creamos un objeto conexion
    $bd = new Conexion();
    //jalamos las subastas que esten activas de la base de datos
    $resultSet = $bd->select("SELECT * FROM sub_subastas WHERE estatus_subasta=1;");
    //obtenemos el arreglo con todas las subastas
    while($subasta = mysqli_fetch_array($resultSet)){
      //recorremos las subastas
      //print_r($subastas);
      //foreach($subastas as $subasta){
      //obtenemos fecha del servidor
      $fecha_servidor = date("Y-m-d H:i:s");
      //declaramos el primer valor de fecha y tiempo
      $datetime1 = date_create($fecha_servidor);
      //declaramos el segundo valor de fecha y tiempo
      $fecha_limite = $subasta["fecha_limite"];
      $datetime2 = date_create($fecha_limite);
      //sacamos la diferencia entre las 2 fechas la limite de la bd y la del servidor
      $interval = date_diff($datetime1, $datetime2);
      //le damos formato al intervalo que nos regreso la diferencia
      $fecha_comparar = $interval->format('%R');
      if($fecha_comparar == "-"){
        //verificamos si tiene alguna oferta esta subasta
        $resultSet2 = $bd->select("SELECT * FROM sub_ofertas_has_clientes WHERE id_subasta=".$subasta["id_subasta"]." ORDER BY id_oferta DESC LIMIT 1");
        //verificamos si nos regreso alguna fila para saber que hacer
        if($resultSet2->num_rows > 0){
          //si tiene alguna oferta nos toma la mas alta del registro
          $oferta = mysqli_fetch_array($resultSet2);
          //agregamos el articulo a la cesta del usuario que gano la subasta
          $result_ganador = $bd->query("INSERT INTO sub_cesta(id_subasta,id_usuario,oferta_final) VALUES(".$oferta["id_subasta"].",".$oferta["id_usuario"].",'".$oferta["cantidad"]."');");
          //verificamos que el insert se haya ejecutado
          if($result_ganador){
            //actualizamos nuestra subasta a ponerla inactiva
            $bd->query("UPDATE sub_subastas SET estatus_subasta=0 WHERE id_subasta=".$oferta["id_subasta"].";");
            //actualizamos la oferta como ganadora
            $bd->query("UPDATE sub_ofertas_has_clientes SET estado=1 WHERE id_oferta=".$oferta["id_oferta"].";");
          }
        }else if($resultSet2->num_rows == 0){ //si no tiene ofertas
          //actualizamos nuestra subasta a ponerla inactiva
            $bd->query("UPDATE sub_subastas SET estatus_subasta=0 WHERE id_subasta=".$subasta["id_subasta"].";");
        }
      } // fin if si ya paso fecha
    //} // fin foreach
    } // fin while
    
  } //fin funcion ajax
?>