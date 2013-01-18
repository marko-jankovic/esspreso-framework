<?php
/**
* every action by default has support for:
* - default autoload model based on controller name
*   default accessing to model object - $this->"controller name"
* 	
* - default autoload view based on action name
* 	first parametar - path to view folder and name of template
*   second parametar - data which we pass to view 
*
*  -if we need default template with common header and footer
*	$this->data['content'] = "path to view folder / name of template";
*	$this->load->view('tpl/template',$this->data);
*
*	loading model $this->load->model('register');
*	loading view $this->load->view('index/register',$this->data);
*   loading helper $this->load->helper('form');
*/


class RegisterController extends Espresso_Controller{
	
	
	
public function indexAction(){
	
	//print_r($this->params);
	
	if(isset($_POST['register'])){
		
		$this->load->model('register');
		
		$this->register->saveParameters($_POST);
		// validate form
		$this->register->validateForm();
		
		// get form errors
		$this->data['info'] = $this->register->getErrors();
		//$this->data['user'] = $this->register->testQuery();
	}
	$this->data['content'] = "register/index";
			
	$this->load->helper('form');
	$this->load->helper('html');
	$this->load->view('layout/layout',$this->data);
	
}

	
}