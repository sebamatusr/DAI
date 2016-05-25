<?php
/**
 * Clase genérica para la conexión a una base de datos
 *
 * @author Jazna
 * @copyright 2016 
 */
require_once 'GenericBL.php';

abstract class DBAbstractModel extends GenericBL{
    /**
    * Host del servidor de base de datos
    * @var string
    * @access private
    */      
    private static $db_host;
    /**
    * Usuario de conexión a la base de datos
    * @var string
    * @access private
    */      
    private static $db_user;
    /**
    * Password de conexión a la base de datos
    * @var string
    * @access private
    */    
    private static $db_pass; 
    /**
    * Nombre la base de datos
    * @var string
    * @access protected
    */    
    protected $db_name; 
    /**
    * Consulta que será ejecutada sobre la base de datos
    * @var string
    * @access protected
    */    
    protected $query;
    /**
    * Resultado de la consulta
    * @var array
    * @access protected
    */        
    protected $rows = array();
    /**
    * Objeto conteniendo la conexión, instancia de mysqli
    * @var object
    * @access private
    */        
    private $conexion;
    /**
    * Mensaje asociado a la conexión
    * @var string
    * @access public
    */      
    public $mensaje = 'Hecho' ;

    # métodos abstractos para que las clases que hereden los puedan implementar

    /**
    * Obtiene un registro de una tabla
    *
    * @return boolean indicando si se rescata o no el registro
    */      
    abstract protected function get();
    /**
    * Crea un nuevo registro de una tabla
    *
    * @param array conteniendo los campos que serán agregados
    */        
    abstract protected function set();
    /**
    * Setea un registro de una tabla
    *
    * @param array conteniendo los campos que serán seteados
    */  
    abstract protected function edit();
    /**
    * Elimina un registro de una tabla
    *
    * @return boolean indiando el éxito/fracaso de la eliminación
    */      
    abstract protected function delete();
    
    # Métodos concretos de la clase

    /**
    * Carga los parámetros de la base de datos
    */       
    protected function setParametros(){
        $database = require_once('../app/config/database.php');
        self:: $db_host = $database['host'];
        self:: $db_user = $database['user'];
        self:: $db_pass = $database['pass'];
        $this->db_name = $database['database'];  
    }

    /**
    * Conectar a la base de datos
    */       
    private function open_connection() {
        $this->conexion = new mysqli(self:: $db_host, self:: $db_user,
        self:: $db_pass, $this->db_name);
    }

    /**
    * Desconectar la base de datos
    */      
    private function close_connection() {
        $this->conexion->close();
    }

    /**
    * Ejecutar un query simple del tipo INSERT, DELETE, UPDATE
    * @return boolean indicando el éxito/fracaso de la operación
    */        
    protected function execute_single_query() {
        $resultado = false;
        if($_POST) {
            $this->open_connection();
            $result = $this->conexion->query($this->query);
            $resultado = ($this->conexion->affected_rows>=1);
            $this->close_connection();
        } else {
            $this->mensaje = 'Metodo no permitido' ;
        }        
        return $resultado;
    }
    
    /**
    * Traer resultados de una consulta en un Array
    */       
    protected function get_results_from_query() {
        $this->open_connection();
        $result = $this->conexion->query($this->query);        

        while ($this->rows[] = $result->fetch_assoc());
        
        $result->close();
        $this->close_connection();
        array_pop($this->rows);
    }    
}  
?>