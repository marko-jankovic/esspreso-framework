<?php 

class Espresso_DbAdapter{

	protected
		$link;

	public function __construct(){
		$this->connect();
	}
	
	/**
	* Connect to the database
	*/
	protected function connect(){
		
		switch(DB_DRIVER){
			
			case 'mysqli':
				$this->link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Error:database connection');
			break;
			
			case 'sqlite':
			
			break;
			
			case 'mysql':
				$this->link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
				mysql_select_db(DB_NAME,$this->link);
			break;
			
			case 'pdo':
				$this->link = new PDO("mysql:host=DB_HOST;dbname=DB_NAME", DB_USER, DB_PASS);
			break;
			
			default:
				die("Error:Db driver ".DB_DRIVER." not found!");
		}
	}
	
}