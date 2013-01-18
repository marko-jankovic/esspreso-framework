<?php

class Espresso_Loader{
			
	private static	$cssFiles	= 1,
					$jsFiles	= 1;
	
	public	$loadView		= true,
			$loadModel		= true;
	
	
	/**
	* Load view and set data if data is passed
	* @param string $name
	* @param array $data 
	*/
	public function view($name,$data = array()){
	
		$this->loadView = false;
		$explode = explode("/",$name);
		$controller = array_shift($explode);
		$action = array_shift($explode);
		
		foreach($data as $key=>$value){
			$$key = $value;
		}
		
		$viewPath = $this->getViewPath($controller, $action);
		
		try{ 
			if(file_exists($viewPath)){
		  		include_once($viewPath);
			}else{
				throw new Espresso_CustomException($name);
			}
		}catch(Espresso_CustomException $e){
		  //display custom message
		  echo $e->errorMessage("Please create file");
		  die();
		}
			
	}
	
	/**
	* Autoload view if view is not loaded from controler action
	* @param string $controller
	* @param string $action
	* @param array $data
	*/
	public function autoloadView($controller,$action,$data = array()){
	
		foreach($data as $key=>$value){
			$$key = $value;
		}
		if(empty($action)){
			$action = $this->defaultAction;
		}
		$viewPath = $this->getViewPath($controller, $action);
		include_once($viewPath);
	}
	
	/**
	* include templates from shared folder
	* @param string $name
	*/
	public function renderShared($name){
		$sharedPath = SHARED_PATH.$name.'.php';
		
		try{ 
			if(file_exists($sharedPath)){
		  		include_once($sharedPath);
			}else{
				throw new Espresso_CustomException($name);
			}
		}catch(Espresso_CustomException $e){
		  //display custom message
		  echo $e->errorMessage("Please create file");
		  die();
		}
	}
	
	/**
	* Load helper
	* @param string $name
	*/
	public function helper($name){
		
		$helper = $name;
		$helperPath = HELPERS_PATH . $helper .'.php';
		
		try{ 
			if(file_exists($helperPath)){
				
				$helper = 'Espresso_Helper_'.$helper;
		  		$this->$name = new $helper();
			}else{
				throw new Espresso_CustomException($name);
			}
		}catch(Espresso_CustomException $e){
		  //display custom message
		  echo $e->errorMessage("Please implement helper");
		  die();
		}
	}
		
	/**
	* Make model if model exist
	* @param $name
	* @return true or error 
	*/	
	public function model($name){
		
		$model = ucfirst($name);
		$modelPath = MODEL_PATH.$model.'.php';
		$className = 'Espresso_Models_'.$model;
		
		try{ 
			if(file_exists($modelPath)){
				$this->database();
				Espresso_Registry::set($name,new $className());
								
			}else{
				throw new Espresso_CustomException($name);
			}
		}catch(Espresso_CustomException $e){
		  //display custom message
		  echo $e->errorMessage("Please implement model");
		  die();
		}
	}
	
	/**
	* load database
	* make avaible database in every model
	* @param $name
	* @return true or error 
	*/	
	public function database(){
		
		$name = DB_CLASS;
		$database = ucfirst($name);
		$databasePath = LIBRARY_PATH.$database.'.php';
		$className = 'Espresso_'.$database;

		try{ 
			if(file_exists($databasePath)){
				if(!Espresso_Registry::exist($className)){
					Espresso_Registry::set($name,new $className());
				}
			}else{
				throw new Espresso_CustomException($name);
			}
		}catch(Espresso_CustomException $e){
		  //display custom message
		  echo $e->errorMessage("Please implement database");
		  die();
		}
		
		
	}
	
	/**
	* check if file exist and return js path
	* @param $name
	* @return $jsUrl
	*/
	public function getJsPath($name){
		
		if(self::$jsFiles > 1) return false;
		
		$jsPath = JS_PATH.$name;
		$jsUrl = JS_URL.$name;
	
		if(file_exists($jsPath)){
			return $jsUrl;
		}
		return false;
	}
		
	/**
	* get js
	* @param $name
	* @return string js href
	*/
	public function getJs($name){
	
		$url = $this->getJsPath($name);
		if($url){
			self::$jsFiles++;
			$tag = '<script type="text/javascript" src="'.$url.'" ></script>';
	        return $tag;
		}
		return false;
	}
		
	/**
	* get css
	* @param $name
	* @return string css href
	*/
	public function getCss($name){
		
		$url = $this->cssPath($name);
		if($url){
			self::$cssFiles++;
			$tag = '<link href="'.$url.'" rel="stylesheet" type="text/css" />';
			return $tag;
		}
		return false;
	}
	
	/**
	* check if file exist and return css path
	* @param $name
	* @return $cssUrl
	*/
	public function cssPath($name){
	
		if(self::$cssFiles > 1) return false;
		
		$cssPath = CSS_PATH.$name;
		$cssUrl = CSS_URL.$name;
	
		if(file_exists($cssPath)){
			return $cssUrl;
		}
		return false;
	}

	private function getViewPath($controller, $action){
		return $viewPath = VIEW_PATH . $controller .'/'. $action .'.php';
	}
}
