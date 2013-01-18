<?php

include_once('Singleton.php');

class Autoload extends Espresso_Singleton{
	
	static private  $file,
					$instance;
	
	protected function __construct(){
		spl_autoload_register(array(__CLASS__, 'loadClass'));
	}
	
	/**
	 * Use this because exception don't work with __autoload()
	 * Tries to autoload classes 
	 * in models, controllers,helpers and library directories.
	 * @param string $className
	 * @return 
	 */
	public static function loadClass($className){
		
		$file = implode(DIRECTORY_SEPARATOR,explode('_',$className));
		$paths = (explode(':',get_include_path()));
		$found = false;

		foreach($paths as $path){
			
			self::$file = str_replace('Espresso/',$path,$file.'.php');

			if(file_exists(self::$file)){
				$found = true;
				
				require_once self::$file;
			}
		}
		try{ 
			if(!$found == true){
				throw new Espresso_CustomException($className);
			}
		}catch(CustomException $e){
		  echo $e->errorMessage("File not found");
		  die();
		}
	}
}