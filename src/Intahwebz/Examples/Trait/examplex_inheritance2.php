<?php

trait TestTrait {
	public static function test(){ echo "A trait!"; }
}

class TestClass {
	use TestTrait;
	public static function test(){ echo "Child class!"; }
}

TestClass::test(); //outputs "Child class!"

?>