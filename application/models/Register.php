<?php

/**
* @todo finish class
*/
class Espresso_Models_Register extends Espresso_Model{
	
	protected	
		$firstName,
		$lastName,
		$email,
		$password,
		$password2,
		$salt = "salt-2011-food-cms",
		$errors = array();
	
	protected static $enableForm = true;	
	
	public function getErrors(){
		
		$info = array(
			'firstName' => $this->firstName,
			'lastName' 	=> $this->lastName,
			'email'		=> $this->email
		);
		
		$info = array('error' => $this->errors ,'data' => $info);
		
		return $info;
	}

	public function testQuery(){
		
		$updateData = array(
			'first_name' => 'ddddsd'
		);
		
		$query = $this->Db
				->update('users',$updateData)
				->where('id','1')
				->end();
				
		
		//self::setFlashMessage($this->Db->status, $this->Db->type);
				
		return $query;
		
		/*foreach($query as $key=>$value){
			echo ("<p>".$value['team']." ".$value['last_name']."<p>");	
		}*/
	}
	

	public function validateForm(){
	
		$this->validateStrings(array("firstName" => $this->firstName,"lastName" => $this->lastName));
		$this->validateEmail($this->email);
		$this->validatePasswords($this->password,$this->password2);
		
		if(self::$enableForm){
			Espresso_Helper_Helper::redirect("login");
		}
	}

	/**
	* validate passwords
	* @param string @pass
	* @param string @pass2
	*/
	public function validatePasswords($pass,$pass2){
		if(!empty($pass) && !empty($pass2)){
			
			if($pass == $pass2){
				/* SHA1 (salt) */
				$this->password = sha1($this->salt . $pass);
			}else{
				$this->errors['password'] = "Password doesn't mach";
				self::$enableForm = false;
			}
		}else{
			$this->errors['password'] = "Password fields are empty";
			self::$enableForm = false;
		}
	}
	
	/**
	* validate email
	* @param string @email
	*/
	public function validateEmail($email){
		
		if(empty($email)){
			$this->errors['email'] = "Field is empty";
			self::$enableForm = false;
			return false;
		}
		
		$email = filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL);
		if(!$email){
			$this->errors['email'] = "email is not valid";
			$this->email = "";
			self::$enableForm = false;
			return false;
		}
		
		$this->email = $email;
	}
	
	
	/**
	* check if arguments are strings
	* @param array @args
	*/
	public function validateStrings($args){
		
		foreach($args as $inputName=>$inputData){
		
			$inputData = filter_var($inputData, FILTER_SANITIZE_STRING);		
									
			if(empty($inputData)){
				$this->errors[$inputName] = "Field is empty!";
				self::$enableForm = false;
			}elseif(!(preg_match('/^\pL+$/u', $inputData))){
				$this->errors[$inputName] = "Only letters [a - z] !";
				self::$enableForm = false;
				
			}
			
			$this->$inputName = $inputData;	
				
		}
	}

}