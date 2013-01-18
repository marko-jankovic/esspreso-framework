<?php

class Espresso_Helper_Helper{

	/*
	* redirect to url
	* @params string $controller
	* @params string $action
	*/
	public static function redirect($controller="",$action=""){
		header("Location:".SITE_ROOT."/".$controller."/".$action);
	}
	
	
	/*
	* show error
	* @params string $message
	* return $error
	*/
	public static function showError($message){
		//TODO make exeption
		$error = ("<p style='background:#FFDA0F;padding:5px;border:1px #5E3000 solid;float:left;'><strong style='color:#222;'>".$message."</strong><br/></p>");
		echo $error;
	}
	
	
	/*
	* dump data into table
	* @params array $params
	* return html structure with array elements
	*/
	public static function dump($params){
		$out = "";
		$out .= "<ul style='border:1px #004477 solid;padding:10px;background:#F7F7F7;'>";
			foreach($params as $key=>$value){
				$out .= "<li>";
					$out .= "<span style='color:#222;'>";
						$out .= $key;
					$out .= "</span> : ";
					$out .= "<span style='color:#004477;'>";
						
						if(is_array($value)){
							$out .= "<ul style='padding-left:30px;'>";
								self::dump($value);
							$out .= "</ul>";	
						}else{
							$out .= $value;
						}
						
					$out .= "</span>";
				$out .= "</li>";
			}
		$out .= "</ul>";
		
		echo $out;
	}

}