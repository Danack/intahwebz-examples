<?php


//Traits have full access to methods and properties of the class that uses them.
//This is not always a good idea -

trait	BadTrait{
	function	magic(){
		$this->foo = "zaz";
	}
}



class 	TestClass{
	use 	BadTrait;

	var		$foo = 'bar';
}

$testClass = new TestClass();

$testClass->magic();

echo "Foo is now ".$testClass->foo."\n"
//Foo is now zaz

//Refactoring + maintaining code that does this will be quite hard as you just when you're
//editing 'BadTrait' it's impossible to see what you're doing.


?>