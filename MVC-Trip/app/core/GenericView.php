<?php
/**
 * Vista genérica
 * Contiene las operaciones básicas de toda vista
 * @author Jazna
 * @copyright 2016 
 */
require_once 'GenericBL.php';
require_once('../app/config/configuracion.php');
class GenericView extends GenericBL {
    /**
    * Módulo al cual pertenece la vista
    * @var string
    * @access protected
    */
    protected static $_modulo;
    /**
    * Prefijo asociado la vista. Los archivos HTML se nombre de la forma prefijo_accion.html
    * @var string
    * @access protected
    */    
    protected static $_prefijo;
    /**
    * Diccionario asociado a la vista
    * @var array
    * @access protected
    */        
    protected static  $_diccionario;

    # Obtiene el contenido de un archivo HTML
    static function get_template($form='agregar') {
        $file = "../site_media/" . self::$_modulo . "/" . self::$_prefijo . "_" . $form . '.html' ;
        $template = file_get_contents($file);
        return $template;
    }

    static function setGenericView($modulo, $prefijo, $diccionario){
        self::$_modulo = $modulo;
        self::$_prefijo = $prefijo;
        self::$_diccionario = $diccionario;
    }

    # Carga los datos dinámicos que tiene la vista
    static function render_dinamic_data($html, $data){
        foreach ($data as $clave => $valor) {
            $html = str_replace("{" . $clave . "}", $valor, $html);
        }
        return $html;
    }	

    # Arma la vista solicitada con los datos entregados
    static function retornar_vista($vista, $data=array()){
        # Rescata el código HTML que formará la vista
        $html = self::get_template('template',self::$_modulo,self::$_prefijo);
        $html = str_replace("{PATH_JS}", Config::get('path_js'), $html);
        $html = str_replace("{PATH_JSFH}", Config::get('path_jsfh'), $html);
        $html = str_replace("{PATH_CSS}", Config::get('path_css'), $html);       
        $html = str_replace("{PATH_BSFH}", Config::get('path_bsfh'), $html); 
        $html = str_replace("{PATH_FOOTER}", Config::get('path_footer'), $html);       
        $html = str_replace("{subtitulo}", self::$_diccionario["subtitulo"][$vista], $html);
        $html = str_replace("{formulario}", self::get_template($vista), $html);
        $html = str_replace("{autor}", Config::get('autor'), $html);

        # Reemplaza los componentes dinámicos 
        $html = self::render_dinamic_data($html, self::$_diccionario['form_actions']);
        $html = self::render_dinamic_data($html, self::$_diccionario['links_menu']);
        $html = self::render_dinamic_data($html, $data);

        # Rescata el mensaje
        if (array_key_exists('mensaje', $data)){
            $mensaje = $data['mensaje'];
        }
        else{
            $mensaje = "Ingrese la información en los campos";
        }

        $html = str_replace("{mensaje}", $mensaje, $html);
        print $html;
    }    
}
?>