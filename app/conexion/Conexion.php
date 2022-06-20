<?php
    //incluimos los parametros necesarios para conectar a unuestro servidor mysql
    //include("MyDBC.php");
    //clase conexion a la db
    class Conexion{
    //variable de conexion
    private $conn = null;
    //constructor de la clase
    public function __construct(){
        $this->conn = new mysqli("localhost", "root", "", "taw_subastas");
        //condicion para veridicar si se hizo exitosamente la conexion
        if ($this->conn->connect_errno) {
            echo "Error MySQLi: ". $this->conn->connect_error;
            exit();
        }
        $this->conn->set_charset("utf8");
    }
    //desructor de la clase
    public function __destruct(){
        $this->CloseDB();
    }
    //metodo para obetener la variable que contiene la conexion (conn)
    public function getConexion(){
        return $this->conn;
    }
    //metodo que ejecuta los querys (selects)
    public function select($qry){
        $result = $this->conn->query($qry);
        return $result;

    }
    //metodo que ejecuta los inserts y regresa verdadero si se hizo exitosamente el registro, sino arroja el error que ocurrio
    public function query($qry){
        if(!$this->conn->query($qry)){
            return false;
        }else{
            return true;
        }
        return null;
    }
      
    //metodo para conectar a otras DB
    public function select_db($db){
      return $this->conn->select_db($db);
    }
    //metodo que es llamado al momento que el constructor inicia para cerrar la conexion a la BD
    public function CloseDB(){
        $this->conn->close();
    }

}//Fin clase
?>
