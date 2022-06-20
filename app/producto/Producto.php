<?php
	include "../conexion/Conexion.php";
  class Producto{
    //atributos
    private $producto;
    private $detalle;
    private $foto;
    private $categoria;
    
    //constructor
    function __construct($producto, $detalle, $foto, $categoria, $usuario){
      $this->producto=$producto;
      $this->detalle=$detalle;
      $this->foto=$foto;
      $this->categoria=$categoria;
      $this->usuario=$usuario;
    }
    
    //metodos
    //funcion para agregar productos
    function agregar($producto,$origen){
      //creamos nuevo objeto de conexion
			$db=new Conexion();
      //creamos una variable destino donde copiaremos la foto que subio el usuario a la carpeta
      $destino = 'img/';
  		copy($origen,$destino.''.$producto->getFoto());
			//realizamos la consulta a ejecutar
			$query="INSERT INTO sub_productos(producto,descripcion,foto,id_categoria,id_usuario) values('".$producto->getProducto()."','".$producto->getDetalle()."','".$producto->getFoto()."',".$producto->getCategoria().",".$producto->getUsuario().");";
			//ejecutamos la consulta a traves de un metodo de nuestro objeto conexion
			$resultado=$db->query($query);
			// con esta condicion verificamos el estado de nuestro insert
			if($resultado){
				return "¡Producto agregado!";
			}else{
				$error=$db->getConexion();
				return "¡Problemas al agregar producto! - ".$error->error;
			}
      
    }
    
    //funcion para eliminar producto
    function eliminar($id_producto,$foto){
      //creamos nuevo objeto de conexion
			$db=new Conexion();
			//realizamos la consulta a ejecutar
			$query="DELETE FROM sub_productos WHERE id_producto=".$id_producto;
			//ejecutamos la consulta a traves de un metodo de nuestro objeto conexion
			$resultado=$db->query($query);
			// con esta condicion verificamos el estado de nuestro insert
			if($resultado){
        unlink("img/".$foto);
				return "¡Producto Eliminado!";
			}else{
				$error=$db->getConexion();
				return "¡Problemas al eliminar producto! - ".$error->error;
			}
      
    }
    //getters
    function getProducto(){
      return $this->producto;
    }
    
    function getDetalle(){
      return $this->detalle;
    }
    
    function getFoto(){
      return $this->foto;
    }
    
    function getCategoria(){
      return $this->categoria;
    }
    
     function getUsuario(){
      return $this->usuario;
    }
  }
?>