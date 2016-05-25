<?php
/**
 * Clase genérica que permite automatizar los GETTER y SETTER
 *
 * @author Jazna
 * @copyright 2016 
 */
class GenericBL {
    /**
    * Conjunto de datos que contiene la clase
    * @var array
    * @access private
    */     
    private $data = array();
                  /*12*/                    
    public function __construct() {
        
    }
    /**
    * Retorna el valor del atributo/propiedad de una clase
    *
    * @return mixed valor del dato solicitado si es que existe
    * @param string $name nombre de la propiedad que se está pidiendo
    */    
    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }        
    }

    /**
    * Setea el valor del atributo/propiedad de una clase
    *
    * @param string $name nombre de la propiedad que se está seteando
    * @param mixed $value valor de la propiedad que se está seteando
    */     
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
}