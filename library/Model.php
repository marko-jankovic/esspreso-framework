<?php

class Espresso_Model{

	public $Db;
	
	public function __construct(){
		
		$name = DB_CLASS;
		// instance of model object
		$this->Db = Espresso_Registry::get($name);
	}

	/**
	* magic method witch will call get and set functions
	* supports only one argument for get and set methods
	* @param $name
	* @param $args
	* @return function $methodProperty
	*/
	public function __call($name, $args){
		//first 3 characters in the name of the method
		$methodPrefix = substr($name, 0, 3);
		//property name
		$methodProperty = strtolower($name[3]) . substr($name,4);
		
		switch($methodPrefix){
			case "get":
				return $this->$methodProperty;
				break;
				
			case "set":
				
				if(count($args) != 1 ){
					die("Default setter supports 1 argument!");
				}else{
					//get first element
					$this->$methodProperty = $args[0];
				}
				break;
				
			default:
				die("Error: Magic method doesn't support that pregix!");
		}
	
		return $this->$methodProperty;
		
	}	
	
	/**
	* set all object vars in array
	* @TODO exape private vars
	*/
	public function prepare(){
		$params = array();
				
		foreach(get_object_vars($this) as $k=>$v){
			if(!empty($v)){
				$params[$k] = $v;
			}
		}
		return $params;
	}
	
	/**
	* save parameters to property
	* @param arrays $params
	*/
	public function saveParameters($params){
		
		foreach($params as $key=>$value){
			if(property_exists($this, $key)){
				$this->$key = $value;
			}
		}
	}
	
	
	/**
	 * set Flash Message
	 * @param string $message
	 * @param string $type [info]
	 */
	public static function setFlashMessage($message, $type="notice"){
		$_SESSION['flash-message'] = array(
			"text" => $message,
			"type" => $type
		);
	}
	
	/*
	* magic method witch will automaticly execute when you echo object
	*/
	public function __toString(){
		return "You must call function to see your data";
	}

}