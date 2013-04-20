<?php

trait Counter {

	var $count = 0;

	public function inc() {
		$this->count = $this->count + 1;
		echo $this->count."\n";
	}
}

class C1 {
	use Counter;
}

class C2 {
	use Counter;
}

$o = new C1(); $o->inc(); // echo 1
$p = new C2(); $p->inc(); // echo 1



?>