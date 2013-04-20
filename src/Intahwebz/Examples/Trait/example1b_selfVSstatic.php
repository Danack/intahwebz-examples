<?php


// Some keywords

// $this - is the current object
// self - is the current class for the method that it is used in.
// static is the late binding class - aka the leaf class aka the most child-ish class

// parent

// __TRAIT__ - name of the trait
// __CLASS__ - the name of the class that the trait is used in
// getClass($this) - gets the actual instance of the class that a trait is contained in

class A {
	public static function get_A() {
		return new self();
	}

	public static function get_me() {
		return new static();
	}
}

class B extends A {
}

echo get_class(B::get_A());  // out put A
echo get_class(B::get_me()); // out put B

echo get_class(A::get_me()); // out put A




?>