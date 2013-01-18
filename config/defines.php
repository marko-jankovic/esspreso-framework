<?php
session_start();

/* Aplication path */

define('ROOT_PATH', realpath("./"));
define('BASE_URL','food_cms'); //TODO remove
define('SITE_ROOT',"http://".$_SERVER['SERVER_NAME']."/".BASE_URL);

// application paths
define('APPLICATION_PATH', ROOT_PATH.'/application/');
define('CONFIG_PATH', ROOT_PATH.'/config/');		
define('MODEL_PATH', APPLICATION_PATH.'models/');
define('VIEW_PATH', APPLICATION_PATH.'views/');
define('CONTROLLERS_PATH', APPLICATION_PATH.'/controllers/');
define('LIBRARY_PATH', ROOT_PATH.'/library/');
define('HELPERS_PATH', LIBRARY_PATH.'/helper/');
define('CLASS_PATH',LIBRARY_PATH.'/class/');

define('PUBLIC_PATH', ROOT_PATH.'/public');
define('CSS_PATH', PUBLIC_PATH.'/css/');
define('JS_PATH', PUBLIC_PATH.'/js/');
define('IMAGES_PATH', PUBLIC_PATH.'/images/');
define('SHARED_PATH', VIEW_PATH.'/shared/');

// url paths to the public folders
define('CSS_URL', SITE_ROOT.'/public/css/');
define('JS_URL', SITE_ROOT.'/public/js/');
define('IMAGES_URL', SITE_ROOT.'/public/images/');

// default controller and action name 
define('DEF_CONTROLLER_NAME','indexController');
define('DEF_CONTROLLER','index');
define('DEF_ACTION','index');

// debug status
define("DEBUG", 1);

if(DEBUG){
	ini_set('display_errors', true);
	ini_set('display_startup_errors', true);
	//ini_set('error_reporting', E_ALL);
}

/* Adding defined paths to array */	
$paths = array(
	LIBRARY_PATH,
	APPLICATION_PATH
);
	
/* Seting paths with PATH_SEPARATOR because deference of OS */	
set_include_path(implode(PATH_SEPARATOR, $paths));
