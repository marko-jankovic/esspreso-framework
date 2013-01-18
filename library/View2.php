<?php

// http://www.patternsforphp.org/doku.php?id=lazy_initialization


class Espresso_View{
	
	protected static	$cssFiles = 1,
						$jsFiles = 1;
	
	protected $defaultAction = "index";
	
	/*
	* include templates from shared folder
	* @param string $name
	*/
	public function renderShared($name){
		$sharedPath = SHARED_PATH.$name;
		if(file_exists($sharedPath)){
			include_once $sharedPath;
		}
		return false;
	}
	
	/*
	* render view page
	*/
	public function render($controller, $action){
		/*
		* if $this->action is empty set default value
		*/
		if(empty($action)){
			$action = $this->defaultAction;
		}
		
		include_once(VIEW_PATH . $controller .'/'. $action .'.php');
	}
	
	
	/**
	* check if file exist and return css path
	* @param $name
	* return $cssUrl
	*/
	public function getCssPath($name){
	
		if(self::$cssFiles > 1) return false;
		
		$cssPath = CSS_PATH.$name;
		$cssUrl = CSS_URL.$name;
	
		if(file_exists($cssPath)){
			return $cssUrl;
		}
		return false;
	}
		
	/**
	* get css
	* @param $name
	* return string css href
	*/
	public function getCss($name){
		
		$url = $this->getCssPath($name);
		if($url){
			self::$cssFiles++;
			$tag = '<link href="'.$url.'" rel="stylesheet" type="text/css" />';
			return $tag;
		}
		return false;
	}
	
	/**
	* check if file exist and return js path
	* @param $name
	* return $jsUrl
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
	* return string js href
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


}