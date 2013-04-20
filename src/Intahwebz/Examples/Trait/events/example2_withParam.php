<?php

require_once('Events.php');

class MyClass {
	use Events;
}


//You can also pass in arguments:
$class = new MyClass();
$class->bind("hello", function($name) {
	echo "hello " . $name;
});

$class->trigger("hello", "Peter");



?>