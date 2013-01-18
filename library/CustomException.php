<?php

class Espresso_CustomException extends Exception{
	
	/**
	* show exception messages
	* @param string $messages
	*/
	public function errorMessage($message){
		
		if(DEBUG == false){
			header("Location:".SITE_ROOT."/error/");
			return false;
		}
	
		//error message
		$style = "style='font-size:15px;border:1px #E6E6E6 solid;padding:15px;color:#333;background:#EDEDE7;-moz-box-shadow:0 2px 4px #E6E6E6;border-bottom:2px solid #fff;-moz-border-radius:6px 6px 6px 6px;'";
		$errorMsg = "<div $style>"; 
			$errorMsg .= "<p style='margin:0px;'><strong>Error was encountered</strong></p>";
			$errorMsg .= "<p style='margin-bottom:0px;'>Message : <span style= 'color:#801B1B'>$message <strong>".$this->getMessage()."</strong></span></p>";
			$errorMsg .= "<p style='margin-bottom:0px;'>File name : ".$this->getFile()." : </p>";
			$errorMsg .= "<p style='margin-bottom:0px;'>Line number : ".$this->getLine()."</p>";
		$errorMsg .= "</div>";
		
		return $errorMsg;
	}
}