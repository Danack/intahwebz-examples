<?php


//If two Traits insert a method with the same name, a fatal error is produced,
//if the conflict is not explicitly resolved.

//To resolve naming conflicts between Traits used in the same class, the insteadof operator
//needs to be used to chose exactly one of the conflicting methods.

//	Since this only allows one to exclude methods, the as operator can be used to
//	allow the inclusion of one of the conflicting methods under another name.

// In this example, Talker uses the traits A and B. Since A and B have conflicting methods,
// it defines to use the variant of smallTalk from trait B, and the variant of bigTalk from trait A.



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

class Talker {
	use A, B {
	B::smallTalk insteadof A;	//Choose between functions
	A::bigTalk insteadof B;
	}
}

class Aliased_Talker {
	use A, B {
		B::smallTalk insteadof A;
		A::bigTalk insteadof B;
		B::bigTalk as talk;  //Alias function to something else
	}
}

echo "Talker\n";
$talker = new Talker();
$talker->bigTalk();
$talker->smallTalk();

echo "\n";
echo "\n";

echo "AliasedTalker\n";
$aliasedTalker = new Aliased_Talker();

$aliasedTalker->bigTalk();
$aliasedTalker->smallTalk();
$aliasedTalker->talk();

echo "\n";


//Again - just because you can doesn't mean you should

?>