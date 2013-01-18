<?php

class Espresso_Controller{
	
	protected	
		$controller,
		$action,
		$params,
		$registry,
		$load,
		$DB;
	
	public $data = array();
	protected static $instances = array();
	
	/**
	* @param $controller
	* @param $action
	*/
	protected function __construct($controller,$action,$params = null){
		
		$this->controller	= $controller;
		$this->action		= $action;
		$this->params		= $params;
		
		// load model
		$this->load			= new Espresso_Loader;
	}

		
	public static function getInstance($controller,$action,$params = null) {
		
		$class_name = get_called_class();
	
		if(! static::$instances[$class_name]) {
			static::$instances[$class_name] = new $class_name($controller,$action,$params ?: array());
		}
		
		return static::$instances[$class_name];
	}

	
	
	
	/**
	* method make posibile to call model methods shorter
	* @param $modelName
	* @return object $object
	*/
	public function __get($modelName){
		
		$object = Espresso_Registry::get($modelName);
		return $object;
	}
	
	/**
	* calling action method
	* if action doesn't exist call errorAction
	* call autoloadView if view isn't loaded from action
	*/
	public function defaultAction(){
		
		ob_start();
		
		$method = $this->action . "Action";

		if(method_exists($this, $method)){
			$this->$method($this->params);
		}else{
			$this->errorAction($this->action);
		}
		
		if($this->load->loadView == true){
			$this->load->autoloadView($this->controller,$this->action,$this->data);
		}
		
		ob_get_flush();
		
		return true;
	}
	
	/**
	* error action
	* show 404
	*/
	public function errorAction($action){
		
		$data['title'] = $action;
		$data['content'] = "error/index";
		$this->load->view('layout/layout',$data);
		return true;
	}
	
	/**
	* redirect to url
	* @param string $controller
	* @param string $action
	*/
	public static function redirect($controller,$action = ""){
		header("Location:".SITE_ROOT."/".$controller."/".$action);
	}

}