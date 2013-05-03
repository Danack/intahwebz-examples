<?php

trait TestTrait {
	public static function test(){ echo "A trait!"; }
}

class ParentClass {
	public static function test(){ echo "Parent class"; }
}

class TestClass extends ParentClass {
	use TestTrait;
}

TestClass::test(); //outputs "A trait!"



?>