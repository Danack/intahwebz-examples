<?php



trait A {
	public function smallTalk() {
		echo 'a';
	}
	public function bigTalk() {
		echo 'A';
	}
}

trait B {
	public function smallTalk() {
		echo 'b';
	}
	public function bigTalk() {
		echo 'B';
	}
}
trait c {
	public function smallTalk() {
		echo 'c';
	}
//	public function bigTalk() {
//		echo 'C';
//	}
}

class Aliased_Talker {
	use A, B, C {
		B::smallTalk insteadof A, C; // or
		//B::smallTalk insteadof C;
		A::bigTalk insteadof B;
		B::bigTalk as talk;  //Alias function to something else
	}
}

$talker = new Aliased_Talker();

$talker->smallTalk();


?>