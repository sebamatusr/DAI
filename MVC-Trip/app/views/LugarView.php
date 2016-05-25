<?php
require_once('../app/core/Controles.php');
require_once('../app/core/GenericView.php');
require_once('../app/config/configuracion.php');
class LugarView extends GenericView{

    static private $configuracion = array(
        "modulo"    => "lugares",
        "prefijo"   => "lugar"
    );

    # Retorna un parámetro especifico de la vista
    static function get($name){
        return self::$configuracion[$name];
    }    

    static function setView(){
        self::setGenericView(self::$configuracion['modulo'], 
            self::$configuracion['prefijo'], 
            self::getDiccionario());
    }

	static function getDiccionario(){
		return $diccionario = array(
			"subtitulo" => array(LUGAR_AGREGAR => "Registrar nuevo lugar", 
                                 EDITAR_LUGAR => "Buscar registro a editar",
                                 USER_LOGIN => "Buscar registro a editar",
                                 VER_USUARIO => "Datos de usuario"),
			"links_menu" => array("NUEVO_LUGAR" => Config::get('path') .
                                                        MODULO_LUGAR . NUEVO_LUGAR . "/",
                                  "EDITAR_LUGAR" => Config::get('path') .
                                                        MODULO_LUGAR . EDITAR_LUGAR . "/"),
                                  "LISTAR_LUGAR" => Config::get('path') .
                                                        MODULO_LUGAR . ELIMINAR_LUGAR . "/"),
			"form_actions" => array("AGREGAR_LUGAR" => Config::get('path') . 
                                                        MODULO_LUGAR . AGREGAR_LUGAR."/",
                                    "BUSCAR_LUGAR" => Config::get('path') . 
                                                        MODULO_LUGAR . EDITAR_LUGAR . "/"),
                                    "MODIFICAR_LUGAR" => Config::get('path') . 
                                                        MODULO_LUGAR . EDITA_AUTOR . "/"),
                                    "MODIFICAR_LUGAR" => Config::get('path') . 
                                                        MODULO_LUGAR . EDITA_AUTOR . "/"),
		);		
	}

    # Muestra los registros presentes en la tabla
    static function mostrar_registros($vista, $data=array(), $registros=array()){
        global $diccionario, $configuracion;
        # Rescata el código HTML que formará la vista
        $html = self::get_template('template');
        $html = str_replace("{PATH_JS}", Config::get('path_js'), $html);
        $html = str_replace("{PATH_JSFH}", Config::get('path_jsfh'), $html);
        $html = str_replace("{PATH_CSS}", Config::get('path_css'), $html);    
        $html = str_replace("{PATH_BSFH}", Config::get('path_bsfh'), $html); 
        $html = str_replace("{PATH_FOOTER}", Config::get('path_footer'), $html);     
        $html = str_replace("{subtitulo}", self::getDiccionario()["subtitulo"][$vista], $html);  
        $html = str_replace("{autor}", Config::get('autor'), $html);      
        
        # Reemplaza los componentes dinámicos 
        $html = self::render_dinamic_data($html, self::getDiccionario()['form_actions']);
        $html = self::render_dinamic_data($html, self::getDiccionario()['links_menu']);        

       
        # Termina de armar la vista 

        $html = str_replace("{formulario}", self::get_template($vista), $html);                        
        $html = self::render_dinamic_data($html, $data);
                 
        print $html;                      
    }    	
}
?>