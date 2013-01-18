<?php

/**
* Form heleper
* @todo finish helper
*/
class Espresso_Helper_Form{

	public function test(){
		echo 'string';
	}
	
	public function formOpen(){}
	
	public function formClose(){}
	
	/**
	* Draw label
	* @param string $text
	* @param string $for
	* @param string $class
	* @param string $id 
	* @return $label
	*/	
	public function label($text, $for = "", $class = "",$id = ""){
		
		$attributes = array(
						'for' => $for,
						'id'  => $id,
						'class' => $class
						);
		$prepared = $this->prepareFormAttributes($attributes);		
		
		$label = "<label $prepared >$text</label>";
		return $label;
	}
	
	/**
	* Draw input text
	* @param string $name
	* @param string $value
	* @param string $class
	* @param string $id 
	* @return $input
	*/	
	public function inputText($name, $value = "",$id = "",$class = ""){
		
		$attributes = array(
						'value' => $value,
						'id'	=> $id,
						'class' => $class,
						'name'	=> $name
						);
		$prepared = $this->prepareFormAttributes($attributes);
		$input = "<input type = 'text' $prepared />";
		
		return $input;
	}
	
	/**
	* Draw input password
	* @param string $name
	* @param string $class
	* @param string $id 
	* @return $input
	*/	
	public function inputPassword($name,$id = "",$class = ""){
		
		$attributes = array(
						'id'	=> $id,
						'class' => $class,
						'name'	=> $name
						);
		$prepared = $this->prepareFormAttributes($attributes);
		$input = "<input type = 'password' $prepared />";
		
		return $input;
	}	
		
	/**
	* Draw submit
	* @param string $name
	* @param string $value
	* @param string $class
	* @return $submit
	*/		
	public function submit($value = "", $name = "", $class = ""){
		
		$attributes = array(
						'value'	=> $value,
						'class' => $class,
						'name'	=> $name
						);
		$prepared = $this->prepareFormAttributes($attributes);
		$submit = "<input type='submit' $prepared />";
		
		return $submit;
	}

	public function showErrors(){}


	private function prepareFormAttributes($attributes){
		
		$prepared = "";
		foreach($attributes as $attribute => $value){
			if(!empty($value)){
				$prepared .= "$attribute = '$value' ";
			}
		}
		
		return $prepared;
	}
}	