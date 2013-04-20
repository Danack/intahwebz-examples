<?php

//traits are interfaces with implementation

//traits are what interfaces should have been.

//language assisted copy and paste.


trait Hello {
	public function sayHello() {
		echo 'Hello ';
	}
}

trait World {
	public function sayWorld() {
		echo 'World!';
	}
}

trait HelloWorld {
	use Hello, World;
}

class MyHelloWorld {
	use HelloWorld;
}

$o = new MyHelloWorld();
$o->sayHello();
$o->sayWorld();


echo "\n";


?>