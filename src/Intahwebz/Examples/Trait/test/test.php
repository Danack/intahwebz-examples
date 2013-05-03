<?php



class A {

	public $a = 1;

	public function testAccess(){
		foreach($this as $key => $value){
			echo "Key $key => $value   \n";
		}
	}

}

class B extends A {
	private $b = 2;
}

$b = new B();

$b->testAccess();


?>