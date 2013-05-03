<?php

//They really are copied and pasted into each class.
//Variables inside traits (or trait functions) have one instance per class that uses them


trait Counter {
	public function inc() {
		static $count = 0;
		$count = $count + 1;
		echo $count."\n";
	}

	public static $classCount = 0;

	public function incClassVar(){
		self::$classCount += 1;
		echo  self::$classCount."\n";
	}
}

class C1 {
	use Counter;
}

class C2 {
	use Counter;
}

$a = new C1();
$a->inc(); // echo 1

$b = new C2();
$b->inc(); // echo 1


$a->incClassVar(); // echo 1
$b->incClassVar(); // echo 1




?>