<?php

/**
* Html helper
* @todo finish helper
*/
class Espresso_Helper_Html{

	/**
	* show flash message (error or info)
	*/
	public function flashMessage(){
		if(isset($_SESSION["flash-message"])){
			$flash = $_SESSION["flash-message"];
			unset($_SESSION["flash-message"]);
			return '<div class="flash-message '.$flash["type"].'">'.$flash["text"].'</div>';
		}
	}

}

?>