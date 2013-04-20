<?php


trait Trait1{

	function testFunction(){
		echo "Hello!\n\n";
	}

	abstract function required();
}


trait Trait2{
	use Trait1;
}

class TestClass{

	use Trait2;

	function	required(){
		echo "Boo.";
	}
}


$class = new TestClass();

$class->testFunction();

?>