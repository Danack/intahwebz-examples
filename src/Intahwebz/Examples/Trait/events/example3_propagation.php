<?php

require_once('Events.php');

class MyClass {
	use Events;
}


//This also supports priority and stopping event propagation. By default, all events are triggered in the order they are bound. You can change that by assiging a priority to an event, and returning false to stop propagation.

$class = new MyClass();
$class->bind("hello", function($name) {
	echo "hello " . $name;
});

$class->bind("hello", function($name) {
	echo "hello my dear sir " . $name;
	return false;

}, 2);

$class->trigger("hello", "Peter");

//	Would produce
//hello my dear sir Peter

?>