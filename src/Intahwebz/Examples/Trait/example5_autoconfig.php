<?php

require_once("autoloader.php");




class Router {

	use AutoConfig;

	var $routes = NULL;

	function	__construct(){
		$this->loadConfig();
	}

	function parseConfig($configDataArray){
		if($configDataArray === NULL){
			//throw new ConfigMissingException("Could not load config for class ".get_class());
			$this->initRouting(array());
		}
		else{
			$this->initRouting($configDataArray);
		}
	}

	function	saveRoutes(){
		$this->saveConfig($this->routes);
	}

	function	initRouting($routeDataArray){

		foreach($routeDataArray as $routeData){
			//$route = new Route($route);
			//$this->routes[] = $route;
			$this->routes[] = $routeData;
		}
	}


	function	addRoute($routeData){
		//$route = new Route($route);
		//$this->routes[] = $route;
		$this->routes[] = $routeData;
	}
}


$homepageRouting = array(
	'name' => 'homepage',
	'pattern' => '/',
	'mapping' => array('HomePage', 'show'),
);


$imagesRouting = array(
	'name' => 'images',
	'pattern' => '/pictures/{page}',
	'mapping' => array('Images', 'show'),
	'defaults' => array(
		'page' => 1
	),
	'requirements' => array(
		'page' => '\d+',
	),
);

$notesAllRouting = array(
	'name' => 'notesAll',
	'pattern' => '/notes',
	'mapping' => array('basereality', 'Notes', 'showAll'),
);


$router = new Router();

$router->addRoute($homepageRouting);
$router->addRoute($imagesRouting);
$router->addRoute($notesAllRouting);
$router->saveRoutes();


var_dump($router->routes);








?>