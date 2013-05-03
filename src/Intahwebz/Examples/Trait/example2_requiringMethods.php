<?php


//Traits are able to express required methods by using abstract method declarations.
//An abstract method can be satisfied in various ways, for instance by implementing
//it in the composing class or by bringing it in from another Trait.



trait Greet {
	abstract public function getName();

	function greet(){
		echo "Hello there ".$this->getName()."\n";
	}
}



class RegisteredUser{

	use Greet;

	var $name = "John";

	function getName(){
		return $this->name;
	}
}


class AnonymousUser{
	use Greet;
}


// PHP Fatal error:  Class AnonymousUser contains 1 abstract method and must therefore be declared
// abstract or implement the remaining methods (AnonymousUser::getName) in
// /documents/projects/traits/intro/example2_requiringMethods.php on line 35





?>