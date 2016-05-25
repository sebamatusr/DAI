<?php
require_once("../app/core/GenericController.php");
require_once("../app/models/User.php");
require_once("../app/views/UserView.php");
/**
 * Controlador del Autor
 *
 * @author Sebastián
 * @copyright 2016 
 */
class UserController extends GenericController{
	static function handler(){
		$evento = NUEVO_USUARIO;	
		$uri = $_SERVER['REQUEST_URI'];

		# Setea la vista
		UserView::setView();

		# Lista de peticiones disponibles
		$peticiones = array(DO_LOGIN, REGISTRAR_USUARIO, USER_LOGIN);

		# Analiza la petición
		foreach ($peticiones as $peticion) {
			$uri_peticion = $peticion . "/";
			if (strpos($uri, $uri_peticion)){
				$evento = $peticion;
			}
		}
		# Obtiene los parámetros que vienen de la URL
		$data = UserController::helper();
		# Crea el objeto
		$objetoPersistente = UserController::setearObjeto();
		# Analiza el evento que debe gatillar
		switch ($evento) {	
			case REGISTRAR_USUARIO:
				# Setea el objeto con los datos que se han recuperado
				$objetoPersistente->set($data);
 				$data["mensaje"] = $objetoPersistente->mensaje;		 					
				UserView::retornar_vista(VER_USUARIO, $data);			
				break;		
			case DO_LOGIN:
				$user = $data['nombre'];
				$pass = $data['password'];

				if($objetoPersistente->getLogin($user,$pass))
				{
					$data['mensaje'] = "¡INGRESO EXITOSO!";
				}
				else
				{
					$data['mensaje'] = "¡INGRESO FALLIDO! Usuario y/o Contraseña erróneos.";
				}				
				UserView::retornar_vista(VER_USUARIO, $data);		
				break;	
			case USER_LOGIN:
				UserView::retornar_vista(USER_LOGIN, $data);
				break;
			default:
				UserView::retornar_vista($evento);
				break;				
		}
	}
	
	# Obtiene los parámetros de la URL
	static function helper(){
		$data = array();
		if ($_POST){
			if(array_key_exists('nombre', $_POST)){
				$data['nombre'] = $_POST['nombre'];
			}
			if(array_key_exists('nombre_real', $_POST)){
				$data['nombre_real'] = $_POST['nombre_real'];
			}			
			if(array_key_exists('pais_origen', $_POST)){
				$data['pais_origen'] = $_POST['pais_origen'];
			}			
			if(array_key_exists('password', $_POST)){
				$data['password'] = $_POST['password'];
			}		
			if(array_key_exists('id', $_POST)){
				$data['id'] = $_POST['id'];
			}										
		}
		#AQUI VIENEN LOS DATOS DE LAS VISTAS 
		elseif ($_GET){
			if (array_key_exists('id', $_GET)){
				$data['id'] = $_GET['id'];
			}
			if (array_key_exists('inicial', $_GET)){
				$data['inicio'] = $_GET['inicial'];
			}			
			if (array_key_exists('final', $_GET)){
				$data['fin'] = $_GET['final'];
			}						
		}
		return $data;
	}

	# Retorna un objeto del modelo
	static function setearObjeto(){
		$objeto = new User();
		return $objeto;
	}	
}
?>