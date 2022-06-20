<?php
include("conexion/Conexion.php");
  if(!isset($_POST)){
    echo "Imposible cargar las ofertas colsultar mas tarde";    
  }else{
    if(isset($_POST["id_subasta"])){
      $bd = new Conexion();
      $resultset = $bd->select("SELECT * FROM sub_ofertas_has_clientes as O, sub_usuarios as U WHERE U.id_usuario=O.id_usuario and O.id_subasta=".$_POST["id_subasta"]);
      
      if($resultset->num_rows > 0){

        while($row = mysqli_fetch_array($resultset)){
?>
          <hr>
            <div class="row">
                <div class="col-md-12">
                    <b><?php echo $row["usuario"];?></b>
                    <span class="pull-right"><b><?php echo $row["fecha_oferta"];?></b></span>
                    <p><small><?php echo $row["usuario"];?> ha ofertado</small> $<?php echo $row["cantidad"];?></p>
                </div>
            </div>
<?php
        }
      }else if($resultset->num_rows == 0){
        echo "<center><h1> ¡No hay ofertas! </h1></center>";
      }
    }
  }
?>