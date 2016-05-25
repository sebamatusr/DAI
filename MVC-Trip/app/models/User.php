<?php

require_once('../app/config/configuracion.php');
require_once('../app/core/GenericModel.php');

/**
 * Modelo de negocio del Autor
 *
 * @author Sebastián
 * @copyright 2016 
 */
class User extends GenericModel { 
    /**
    * Crear un nuevo registro
    *
    * @param array $data colección de datos del autor
    */      
    public function set($data=array()) {
        
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        if(self::getByNombre($nombre))
        {
            $this->mensaje = "El nombre de usuario ya existe";
        }
        else
        {
            $isAdmin=0;
            $this->query = "INSERT INTO users(username, realname, password, nacionalidad, isAdmin)
                            VALUES('$nombre', '$nombre_real','$password','$pais_origen' ,'$isAdmin')";                
            $resultado = $this->execute_single_query();
            $this->mensaje = ($resultado?Config::get('msg_agregar'):Config::get('msg_accesofracaso')) ;  
        }

        
    }
    
    /**
    * Traer datos de un registro, dado su ID
    *
     * @return boolean indicador de éxito/fracado de búsqueda
    * @param int $id id del registro buscado
    */     
    public function get($id='' ) {  
        if($id != '') {
            $this->query = "SELECT username, realname, password, nacionalidad, isAdmin
                            FROM users
                            WHERE userID = $id";            
            $this->get_results_from_query();            
        }        
        if(count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {                                
                $this->$propiedad = $valor;
            }
            $this->mensaje = Config::get('msg_exito'); 
            return true;
        } else {
            $this->mensaje =  Config::get('msg_fracaso'); 
            return false;
        }
        return false;
    }
    public function getByNombre($nombre='' ) {  
        if($nombre != '') {
            $this->query = "SELECT username, realname, password, nacionalidad, isAdmin
                            FROM users
                            WHERE username = '$nombre'";            
            $this->get_results_from_query();            
        }        
        if(count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {                                
                $this->$propiedad = $valor;
            }
            $this->mensaje = Config::get('msg_exito'); 
            return true;
        } else {
            $this->mensaje =  Config::get('msg_fracaso'); 
            return false;
        }
        return false;
    }
    public function getLogin($nombre='', $password='') {  
        if($nombre != '' && $password != '') {
            $this->query = "SELECT username, realname, password, nacionalidad, isAdmin
                            FROM users
                            WHERE username = '$nombre' AND password = '$password'";            
            $this->get_results_from_query();            
        }        
        if(count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {                                
                $this->$propiedad = $valor;
            }
            $this->mensaje = Config::get('msg_exito'); 
            return true;
        } else {
            $this->mensaje =  Config::get('msg_fracaso'); 
            return false;
        }
        return false;
    }
    /**
     * Edita un registro
     * 
     * @param array $data colección de datos del registro editado
     */
    public function edit($data=array()) { 
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        $this->query = "
                UPDATE users
                SET username='$nombre',
                    password='$password'
                WHERE userId = '$id'
            ";          
        $this->mensaje = ($this->execute_single_query()?Config::get('msg_modificar'): Config::get('msg_accesofracaso'));
    }    

    /**
     * Elimina un registro, físicamente, de la base de datos
     * @return boolean, indica éxito/fracaso de la operación
     */
    public function delete(){
        $this->mensaje = "Método NO permitido";
        return false;
    }   

    # Método constructor
    function __construct() {
        parent::__construct();
    }

    # Método destructor del objeto
    function __destruct() {
        parent::__destruct();
    }       
}
?>