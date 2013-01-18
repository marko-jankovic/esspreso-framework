<?php

class Espresso_Dispatcher{


	/**
	* 
	*/
	public static function dispatch(){
	      
	    Espresso_Router::parseUri();  
	    // load the Router library and get the URI
	    $controller			= Espresso_Router::getController();
	    $action				= Espresso_Router::getAction();
	    $params				= Espresso_Router::getParams();
	    $controllerName		= Espresso_Router::getControllerName();
	 	
	 	$controllerPath		= CONTROLLERS_PATH.$controllerName.".php";

		 try {
		 	if(file_exists($controllerPath)){
		 		
		 		include_once($controllerPath);
		 	
				if(class_exists($controllerName)) {
			 	
			 		// Instantiate Controller
			 		$obj = $controllerName::getInstance($controller,$action,$params);
			 		// Execute Page Request
			 		call_user_func_array(array($obj, 'defaultAction'), array());
			 	
			 	}else{
			 		$msg = "Please implement class {$contrillerName}";
			 		throw new Espresso_CustomException($controllerName);
			 	}
		 	}else{
		 		$msg = "Please create file {$contrillerName}";
		 		throw new Espresso_CustomException($controllerName);
		 	}
		 	
		 }catch(Espresso_CustomException $e) {
		 	echo $e->errorMessage($msg);
			die();
		 }
	}
}