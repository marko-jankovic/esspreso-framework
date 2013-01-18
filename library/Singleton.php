<?php 

class Espresso_Singleton{
	
	protected static $instances = array();
	
	final public static function getInstance() {
	
		$className = get_called_class();
		if(!array_key_exists($className, static::$instances)) {
	    	static::$instances[$className] = new $className();
	  	}
	  	return static::$instances[$className];
	}
	
	// overridden by some subclasses
	protected function __construct(){}
	
	// prevent cloning instance of the registry
	protected function __clone(){}
}