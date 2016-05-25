<?php
require_once('../app/core/Controles.php');
require_once('../app/core/GenericView.php');
require_once('../app/config/configuracion.php');
class UserView extends GenericView{

    static private $configuracion = array(
        "modulo"    => "users",
        "prefijo"   => "user"
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
			"subtitulo" => array(NUEVO_USUARIO => "Registrar nuevo usuario", 
                                 USER_LOGIN => "Inicio de sesión",
                                 VER_USUARIO => "Datos de usuario"),
			"links_menu" => array("NUEVO_USUARIO" => Config::get('path') .
                                                        MODULO_USUARIO . NUEVO_USUARIO . "/",
                                  "USER_LOGIN" => Config::get('path') .
                                                        MODULO_USUARIO . USER_LOGIN . "/"),
			"form_actions" => array("DO_LOGIN" => Config::get('path') . 
                                                        MODULO_USUARIO . DO_LOGIN ."/",
                                    "REGISTRAR_USUARIO" => Config::get('path') . 
                                                        MODULO_USUARIO . REGISTRAR_USUARIO . "/")
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