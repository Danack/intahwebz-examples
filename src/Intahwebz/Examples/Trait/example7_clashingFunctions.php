<?php

trait BigTalk {
	function talk(){
		echo "HELLO";
	}
}

trait SmallTalk {
	function talk(){
		echo "hello";
	}
}


class Talker {

	use BigTalk, SmallTalk;

	function testFunction(){
		echo "How does PHP handle this?";
		$this->talk();
	}
}

$talker = new Talker();

$talker->testFunction();

//PHP Fatal error:  Trait method talk has not been applied, because there are collisions with other trait methods on Talker in example7_clashingFunctions.php on line 24
P

?>