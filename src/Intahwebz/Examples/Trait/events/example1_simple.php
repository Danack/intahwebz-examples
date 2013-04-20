<?php

require_once('Events.php');

class MyClass {
	use Events;
}


//Binding and triggering events
$class = new MyClass();
$class->bind("boom", function() {
	echo "headshot";
});

$class->trigger("boom");


?>