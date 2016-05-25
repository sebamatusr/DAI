<?php
/**
 *
 * Controller genérico
 * Contiene las operaciones básicas de un controlador
 *
 * @author Jazna
 * @copyright 2016 
 */
abstract class GenericController{
    /**
    * Contiene las acciones a ejecutar por el controlador
    *
    */ 	
	protected static function handler(){}
    /**
    * Obtiene los datos de la URL
    *
    * @return array datos recuperados desde la URL
    */ 		
	protected static function helper(){}
    /**
    * Crea el objeto asociado al controlador
    *
    * @return mixed objeto sobre el cual va a operar el controlador
    */ 	
	protected static function setearObjeto(){}
}
?>