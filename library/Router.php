<?php
/**
 * Routes requests to the appropriate controller's methods.
 */
class Espresso_Router {
   
	private static
		$controllerName,
		$controller,
		$action,
		$uri,
		$params			= array(),
		$routes			= array();
	
	/**
	* parse uri,set controller,action and params
	* @todo exape '?' from uri
	*/
	public static function parseUri(){
	    	    
	    self::$uri	= strtolower($_SERVER['REQUEST_URI']);	    
	    	    
	    // Split the URI and clean it up, removing empty parts
	    self::$uri = trim(self::$uri, '/ ');
	    $parts = array();
	    
	    // explode uri
		if (!empty(self::$uri)) {
		    $parts = explode('/', self::$uri);
		}
	    
	    // TODO remove
	    foreach($parts as $part){
	    	if($part != BASE_URL){
	    		$request[] = $part;
	    	}
	    }
	    	    
	    // set controller 
		self::$controller = (!empty($request)) ? array_shift($request) : "";
		
		if(array_key_exists(self::$controller,self::$routes)){
			foreach(self::$routes[self::$controller] as $value){
				$temp[] = $value;
			}
			self::$controller = $temp[0];
			self::$action	 = $temp[1];
		
		}elseif(empty(self::$controller) && empty(self::$action)){
			
			self::$controller = self::$routes['root'][0];
			self::$action = self::$routes['root'][1];
			
		}else{
			self::$action = (!empty($request)) ? array_shift($request) : DEF_ACTION;
		} 
	     
		// set arguments 
		if(!empty($request)){
			foreach($request as $param){
				self::$params[] = $param;
			}
	    }
	    
	    // set controller $controller."Controller"

	    self::setControllerName();
	    
	    return true;
	}
	
	public static function root($value){
		if(!empty($value)){
			if(empty(self::$routes)){
				self::$routes['root'] = explode('/',$value);
			}
		}
		
		//print_r(self::$routes);
	}
	
	public static function match($key, $value){
		if(!empty($key) && !empty($value)){
			if(empty(self::$routes[$key])){
				self::$routes[$key] = explode('/',$value);
			}
		}
		//print_r(self::$routes);
	}

	/* get controller */
	public static function getController(){
		return self::$controller;
	}
	
	/* get action */
	public static function getAction(){
		return self::$action;
	}
	
	/* get params */
	public static function getParams(){
		return self::$params;
	}
	
	/* get controller name */
	public static function getControllerName(){
		return self::$controllerName;
	}
	
	/* set controller name */
	private static function setControllerName(){
		self::$controllerName = ucfirst(self::$controller)."Controller";
	}
	
}