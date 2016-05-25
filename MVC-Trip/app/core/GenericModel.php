<?php
/**
 * Estructura base para todas las clases que representan modelos
 *
 * @author Jazna
 * @copyright 2016 
 */
require('DBAbstractModel.php');
class GenericModel extends DBAbstractModel{
    /**
    * Nombre del modelo al cual se está haciendo referencia
    * @var string
    * @access protected
    */     
	protected $_model;
    /**
    * Nombre de la tabla asociada al modelo
    * @var string
    * @access protected
    */     
	protected $_table;
    /**
    * Colección conteniendo el nombre de las relaciones del tipo 1:n que mantiene el modelo
    * @var array indicando nombre de la relación y nombre de la tabla asociada
    * @example 'pertenece' => 'empresa'
    * @access protected
    */      
    protected $_hasMany;
    /**
    * Colección conteniendo el nombre de las relaciones del tipo 1:1 que mantiene el modelo
    * @var array indicando nombre de la relación y nombre de la tabla asociada
    * @example 'pertenece' => 'empresa'
    * @access protected
    */          
    protected $_hasOne;
 
    function __construct() {
        $this->setParametros();
        $this->_model = get_class($this);
        $this->_table = strtolower($this->_model);
    }
 
    function __destruct() {
    	unset($this);
    }	

    function __call($method_name, $arguments) {
        $accepted_methods = array("generateQuery");
        if(!in_array($method_name, $accepted_methods)) {
            trigger_error("Metodo <strong>$method_name</strong> no existe", E_USER_ERROR);
        }

        if(count($arguments) == 0) {
            return $this->generateQuerySingle();
        } elseif(count($arguments) == 1) {
            return $this->generateQuerySingle($arguments[0]);
        } elseif(count($arguments) == 3) {
            return $this->generateQueryFilter($arguments[0], $arguments[1], $arguments[2]);
        } else {
            return false;
        }
    }    

    # métodos abstractos para que las clases que hereden los puedan implementar
    protected function get(){}
    protected function set(){}
    protected function edit(){}
    protected function delete(){}    

    private function generateQuerySingle($order = ''){
        return "SELECT * FROM " . $this->_table . (!empty($order)?" ORDER BY " . $order:""); 
    }

    private function generateQueryFilter($filter, $inicio, $fin){
        return "SELECT * FROM " . $this->_table . " WHERE " . $filter . 
                            " BETWEEN " . $inicio . " AND " . $fin;  
    }

    # Método genérico para ejecutar una consulta y retornar el resultado
    private function executeQuery(){
        # Ejecuta la consulta
        $this->get_results_from_query();
        $this->mensaje = 'Registros de ' . $this->_table . '. Hay ' . count($this->rows) . ' registros' ;
        $registros = array();
        for($indice = 1; $indice <= count($this->rows); $indice++){
            # Obtiene la clase
            $objeto = new $this->_model;
            foreach ($this->rows[$indice-1] as $propiedad=>$valor) {              
                $objeto->$propiedad = $valor;
            }                
            $registros[$indice-1] = $objeto;                
        }
        # Retorna el resultado
        return $registros;                
    }

    # Método genérico para obtener el contenido de una tabla
    function select($order = '', $filter= '', $inicio = '', $fin = ''){
        if ($filter != '' && $inicio != '' && $fin != ''){
            $this->query = $this->generateQuery($filter, $inicio, $fin);
        }
        else{
            $this->query = $this->generateQuery($order);               
        }        
        return $this->executeQuery();
    }

    private function generateQueryHasOne($nameRelation){
        return "SELECT * FROM " . $this->_hasOne[$nameRelation];
    }

    # Método genérico para obtener los registros de la relación hasOne de la tabla
    function selectHasOne($relation){
        $this->query = $this->generateQueryHasOne($relation);
        return $this->executeQuery();
    }
}
?>