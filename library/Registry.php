<?php
	
class Espresso_Registry{

	private static $instance	= null;
	private $objects			= array();

	private function __construct(){}
	//prevent clone
	private function __clone(){}

	/**
	* singleton function return one instance
	* @return self::$instance; 
	*/
	public static function instance(){
	    
	    if(!isset(self::$instance)){
	        self::$instance = new self;
	    }
	    return self::$instance;
	}
	
	public function __isset($name) {
	    return isset($this->objects[$name]);
	}
	
	/**
	* Retrieve a variable from the $this->objects
	* @param string  $name
	* @return null if key not found
	*/
	public function __get($name){
	    // Check key exists
	    if (!array_key_exists($name, $this->objects)){
	        return null;
	    }
	    return $this->objects[$name];
	}

	/**
	* Store a variable in $this->objects
	* @param string $name
	* @param mixed $value
	*/
	public function __set($name, $value){
		
		if(!isset($this->objects[$name])){
			$this->objects[$name] = $value;
		}
		$this->objects[$name] = $value;
	}
    
	/**
	* Statically get stored object.
	* @param string  $name
	* @return object
	*/
	public static function get($name){
	    $instance = self::instance();	    
	    return $instance->$name;
	}

	/**
	 * Statically set class instance.
	 * @param string $name
	 * @param mixed  $value
	 */
	public static function set($name, $value){
	    $instance = self::instance();
	    $instance->$name = $value;
	}
    
	/**
	* Statically check whether a variable has been stored
	* @param string  $name
	* @return boolean
	*/
	public static function exist($name){
		$instance = self::instance();
		return isset($instance->$name);
	}
 
	/**
	* Statically remove a variable from the store
	* @param string $name
	*/
	public static function remove($name){
		$instance = self::instance();
		unset($instance->objects[$name]);
	}       
	
}