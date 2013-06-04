<?php



trait	TestTrait{
	function	compileTimeJoy(){
		echo "Firing up trait [". __TRAIT__."] in class [".__CLASS__."]\n";
	}
}


class 	TestClass{
	use TestTrait;
}

class 	SecondTestClass{
	use TestTrait;
}

$testClass = new TestClass();
$testClass->compileTimeJoy();

$secondTestClass = new SecondTestClass();
$secondTestClass->compileTimeJoy();

//Firing up trait [TestTrait] in class [TestClass]
//Firing up trait [TestTrait] in class [SecondTestClass]

?>