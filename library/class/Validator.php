<?php

	class Espresso_Class_Validator {
	
		
		protected	$inputType,
					$required,
					$errors,
					$submitted,
					$missing,
					$filtered,
					$filterArgs;
		
		/**
		* @param array $required
		* @param string $inputType
		*/
		public function __construct($required = array(), $inputType = "post"){
		
			$this->required		= $required;
			$this->inputType	= $this->inputType($inputType);
		}
		
		
		protected function isInt($int, $min = null, $max = null){
			
			if(is_int($min) && is_int($max)){
				return filter_var($int, FILTER_VALIDATE_INT, array("min_range"=>$min, "max_range"=>$max));
			}else{
				return filter_var($int, FILTER_VALIDATE_INT);
			}
		}
		
		protected function isString($string){
			
			$string = filter_var($string, FILTER_SANITIZE_STRING);		
									
			if(empty($string)){
				return "Field is empty!";
			}elseif(!(preg_match('/^\pL+$/u', $string))){
				return "Only letters [a - z] !";	
			}else{
				return $string;
			}
		}

		/**
		* validate email
		* @param string @email
		*/
		public function isEmail($email){
			
			if(empty($email)){
				$this->errors['email'] = "Field is empty";
				return false;
			}
			
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);
			if($email === false){
				$this->errors['email'] = "Email is not valid";
				return false;
			}
		}

	}
	
	
	