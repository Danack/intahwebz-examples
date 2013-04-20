<?php




trait Singleton{

	private static $instance = null;

	/**
	 * @return static
	 */
	public static function getInstance(){

		if(static::$instance == null){
			$newInstance = new static();

			echo "Creating class ".get_class($newInstance)."\n";

			static::$instance = $newInstance;
		}

		return static::$instance;
	}

//	function initInstance(){
//	}
};



class 	TestClass{

	use Singleton;
}

class 	SecondTestClass{

	use Singleton;
}


$testClass = TestClass::getInstance();

$testClass2 = TestClass::getInstance();

$testClass2 = SecondTestClass::getInstance();

?>