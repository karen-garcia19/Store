<?php
include "../conexion/Conexion.php";
  class Subasta{
    //atributos
    private $fecha_subasta;
    private $fecha_limite;
    private $oferta_inicial;
    private $oferta_final;
    private $producto;
    private $usuario;
    
    //constructor
    function __construct($fecha_subasta, $fecha_limite, $oferta_inicial, $oferta_final, $producto, $usuario){
      $this->fecha_subasta=$fecha_subasta;
      $this->fecha_limite=$fecha_limite;
      $this->oferta_inicial=$oferta_inicial;
      $this->oferta_final=$oferta_final;
      $this->producto=$producto;
      $this->usuario=$usuario;
    }
    
    //metodos
    //funcion para agregar productos
    function agregar($subasta){
      //creamos nuevo objeto de conexion
			$db=new Conexion();
			//realizamos la consulta a ejecutar
			$query="INSERT INTO sub_subastas(fecha_subasta,fecha_limite,oferta_inicial,oferta_final,id_producto,estatus_subasta,id_usuario) values('".$subasta->getFechaSubasta()."','".$subasta->getFechaLimite()."','".$subasta->getOfertaIni()."','".$subasta->getOfertaFin()."',".$subasta->getProducto().",1,".$subasta->getUsuario().");";
			//ejecutamos la consulta a traves de un metodo de nuestro objeto conexion
			$resultado=$db->query($query);
			// con esta condicion verificamos el estado de nuestro insert
			if($resultado){
				return "¡Subasta agregada!";
			}else{
				$error=$db->getConexion();
				return "¡Problemas al agregar subasta! - ".$error->error;
			}
      
    }
    
    //funcion para eliminar producto
    function eliminar($id_subasta){
      //creamos nuevo objeto de conexion
			$db=new Conexion();
			//realizamos la consulta a ejecutar
			$query="DELETE FROM sub_subastas WHERE id_subasta=".$id_subasta;
			//ejecutamos la consulta a traves de un metodo de nuestro objeto conexion
			$resultado=$db->query($query);
			// con esta condicion verificamos el estado de nuestro insert
			if($resultado){
				return "¡subasta Eliminado!";
			}else{
				$error=$db->getConexion();
				return "¡Problemas al eliminar subasta! - ".$error->error;
			}
      
    }
    //getters
    function getFechaSubasta(){
      return $this->fecha_subasta;
    }
    
    function getFechaLimite(){
      return $this->fecha_limite;
    }
    
    function getOfertaIni(){
      return $this->oferta_inicial;
    }
    
    function getOfertaFin(){
      return $this->oferta_final;
    }
    
    function getProducto(){
      return $this->producto;
    }
    
    function getUsuario(){
      return $this->usuario;
    }
  }
?>