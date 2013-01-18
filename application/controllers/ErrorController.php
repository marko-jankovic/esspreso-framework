<?php

class ErrorController extends Espresso_Controller{
	
	public function indexAction(){
		
	}
	
	public function underConstructionAction(){
		$this->load->view('error/sistemError');
	}
}