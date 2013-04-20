<?php

//Why traits are better than interfaces


// Interface version

class Logger {

	static function getInstance($className){
		//Make instance for class
	}

	function log($string){
		echo $string;
	}
}

class TestClass implements Logable {

	var $logger = null;

	function	__construct(){
		$this->logger = Logger::getInstance(get_class());
	}

	function log($string){
		$this->logger->log($string);
	}
}

$testClass = new TestClass();

$testClass->log("That's a lot of code.!");

////////////////////////////////////////////////////
//Using trait
////////////////////////////////////////////////////
trait Log{
	static function getInstance($className){
		//Make instance for class
	}

	function log($string){
		echo $string;
	}
}


class TestClass2{
	use Log;  //1 line inside class
}

////////////////////////////////////////////////////
//Using trait
////////////////////////////////////////////////////


$testClass2 = new TestClass2();

$testClass2->log("woot!");








?>