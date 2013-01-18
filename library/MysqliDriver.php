<?php

class Espresso_MysqliDriver extends Espresso_DbAdapter{
	
	protected 
		$query,
		$arguments	= array(),
		$paramTypeList,
		$rowID;
		
	public	$result,
			$status,
			$type; 

	public function __construct(){
	
		parent::__construct();
		$this->connect();
	}
	
	/**
	* Query method for all complicate statments such inerjoin etc... 
	* @param string $query
	*/
	public function query($query){
		
		$this->query = filter_var($query, FILTER_SANITIZE_STRING);
		$stmt = $this->prepareQuery();
		$stmt->execute();		
		$results = $this->bindResults($stmt);
		
		return $results;
	}
	
	/**
	* prepare query
	* @return string $stmt
	*/
	private function prepareQuery(){
		if(!$stmt = $this->link->prepare($this->query)){
			return false;
		}
		return $stmt;
	}
	
	/**
	* determine value type
	* this is good for security
	* @param $value
	* @return string $paramType
	*/
	protected function determineType($value){
		
		switch(gettype($value)){
			case 'string' :
				$paramType = 's';
				break;
			case 'integer' :
				$paramType = 'i';
				break;
			case 'blob' :
				$paramType = 'b';
				break;
			case 'double' :
				$paramType = 'd';
				break;
		}
		return $paramType;
	}
	
	/**
	* dynamic bind results
	* @param $stmt
	* @return object $results
	*/
	private function bindResults($stmt){
	
		$params = array();
		$results = array();
		$singleRow = array();
		
		$meta = $stmt->result_metadata();

		while($field = $meta->fetch_field()){
			// creating referece &$row
			$params[] = &$row[$field->name];
		}
		
		/* call function with the parameters in $params array */
		call_user_func_array(array($stmt,'bind_result'), $params);
		
		/*
			$results is array witch contain all requared data from table
			$singleRow[$key] = $val => $temp['email'] = example@google.com	
		*/
		while($stmt->fetch()){
			foreach($row as $key=>$val){
				$singleRow[$key] = $val; 
			}
			$results[] = $singleRow;
		}
		return $results;
	}
	
	private function setArguments($field, $value){
		
		$this->paramTypeList .= $this->determineType($value);
		$this->params[$field] = $value;
		
		return true;
	}
	
	/**
	* Select data
	* @param string $tableName
	* @param $fields
	* @return array $results
	*/
	public function select($fields = "",$tableName = ""){		
		
		if(empty($fields)){
			$fields = "*";
		}
		$this->query = "SELECT $fields FROM $tableName";
			
		return $this;
	}

	/**
	* Where statment
	* set $field and $value in $this->whereStmt
	* check $value type 
	* @param string $field
	* @param $value
	* @param $expression
	* @return $this for chaning
	*/
	public function where($field, $value, $expression = ""){
	
		if(empty($expression)){
			$expression = " = ";
		}
		
		$this->query .= " WHERE ".$field.$expression."?";
		$this->setArguments($field, $value);
						 
		return $this;
	}
	
	/**
	* Insert data
	* @param string $tableName
	* @param string $insertData
	*/
	public function insert($tableName, $insertData){
		
		$this->stmtType = "insert";
		$this->query = "INSERT into $tableName ";
		$this->buildInsert($insertData);
		
		return $this;
	}
	
	
	/**
	* Update data
	* @param string $tableName
	* @param string $insertData
	*/
	public function update($tableName, $updateData){
		
		$this->stmtType = "update";
		$this->query = "UPDATE $tableName SET ";
		$stmt = $this->buildUpdate($updateData);
		
		return $this;
	}
	
	public function orStmt($field, $value){
	
		$this->query .= " OR $field = ?";
		$this->setArguments($field, $value);
						 
		return $this;
	}
	
	public function andStmt($field, $value){
	
		$this->query .= " AND $field = ?";
		$this->setArguments($field, $value);
						 
		return $this;
	}
	
	/**
	* Delete data
	* @param string $tableName
	*/
	public function delete($tableName){
		
		$this->stmtType = "delete";
		$this->query = "DELETE FROM $tableName";
		return $this;
	}
	
	public function end(){
		
		$this->arguments[] = $this->paramTypeList;
		
		if(!empty($this->params)){
			foreach($this->params as $field => $value){
				$this->arguments[] = &$this->params[$field];
			}
		}
		$stmt = $this->prepareQuery();
		if(!$stmt){
			$this->status	= "Problem preparing query";
			$this->type		= "error";
			return false;
		}
		
		if(!empty($this->params)){
			call_user_func_array(array($stmt, 'bind_param'), $this->arguments);
		}
		$stmt->execute();
		
		//$this->setStatus($this->stmtType, $stmt);
		
		if(empty($this->stmtType)){
			$results = $this->bindResults($stmt);
			if(!$results){
				return ("There is not data which correspond this request");
			}
			return $results;
		}
	}
	
	/**
	* @todo finish
	*/
	public function setStatus($type, $stmt){
		if($stmt->affected_rows == 0){
			$this->status	= $type." error,query can not be executed";
			$this->type		= "error";
			return true;
		}elseif($stmt->affected_rows == -1){
			$this->status	= $stmt->error;
			$this->tyoe		= "error";
		}else{
			$this->status	= "success ".$type."d!";
			$this->type		= "info";
			return true;
		}
	}
	
	/**
	* Limit statment
	* @param number $numRows default = 1
	* @return $this for chaning
	*/
	public function limit($numRows = "1"){
		if(isset($numRows)){
			$this->query .= " LIMIT ".(int)$numRows;
		}
		return $this;
	}
	
	/**
	* Order by statment
	* @param string $fields
	* @param string $order default = "ASC"
	* @return $this for chaning
	*/
	public function orderBy($fields = "", $order = "ASC"){
		
		$this->query .= " ORDER BY ".$fields." ".$order;
		return $this;
	}
	
	/**
	* build insert statment
	* based on determine type and "?"
	* safe for sql injection
	* @param $tbaleName
	* @param $insertedData
	* @return $stmt
	*/
	private function buildInsert($insertData){
		
		$keys = array_keys($insertData);
		$values = array_values($insertData);
		$num = count($keys);
		
		foreach($values as $key=>$val){
			$this->setArguments($key, $val); 
		}
		
		$this->query .= '(' . implode($keys, ',') . ')';
		$this->query .= ' VALUES (';
		
		while($num !== 0){
			($num !==1) ? $this->query .= '?, ' : $this->query .= '?)';
			$num--;
		}
		return true;
	}
	
	/**
	* build update statment
	* @param $updateData 
	* @return object $stmt
	*/
	private function buildUpdate($updateData){
		
		foreach ($updateData as $field => $value){
			
			$i = 1;
			// prepares the reset of the SQL query.
			if ($i === count($updateData)) {
				$this->query .= $field . " = ? ";
			}else{
				$this->query .= $field . ' = ?, ';
			}
			$i++;
		}
		foreach($updateData as $field=>$val){
			$this->setArguments($field, $val); 
		}
		
		return true;
	}	

}